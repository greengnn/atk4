<?
class ApiAdmin extends ApiWeb {
    public $page_title = null;

    public $layout = null;      // layout used to render everything
    public $info_messages = array();

    public $apinfo=array();
    function __construct($realm=null,$layout='kt2'){
        $this->layout=$layout;
        parent::__construct($realm);
    }
    function init(){
        parent::init();

        $this->initializeTemplate();
        $this->addHook('api-defaults',array($this,'initDefaults'));
    }
    function defaultTemplate(){
        return array('shared','_top');
    }

    function dbConnect($dsn=null){
        include_once'DBlite.php';
        if (is_null($dsn)) $dsn=$this->getConfig('dsn');
        $result = $this->db=DBlite::tryConnect($dsn);
        if(is_string($result))throw new DBlite_Exception($result,"Please edit 'config.php' file, where you can set your database connection properties",2);
    }

    /////////////// H e l p e r   f u n c t i o n s ///////////////
    function stickyGET($name){
        $this->sticky_get_arguments[$name]=$_GET[$name];
    }
    function getDestinationURL($page=null,$args=array()){
        /**
         * Construct URL for getting to page
         */
        
        // If first argument is null, stay on the same page
        if(!isset($page))$page=$this->page;

        // Check sticky arguments. If argument value is true, 
        // GET is checked for actual value.
        if(isset($this->sticky_get_arguments)){
            foreach($this->sticky_get_arguments as $key=>$val){
                if($val===true){
                    if(isset($_GET[$key])){
                        $val=$_GET[$key];
                    }else{
                        continue;
                    }
                }
                if(!isset($args[$key])){
                    $args[$key]=$val;
                }
            }
        }

        // construct query string
        $tmp=array();
        foreach($args as $arg=>$val){
            if(!isset($val) || $val===false)continue;
            if(is_array($val)||is_object($val))$val=serialize($val);
            $tmp[]="$arg=".urlencode($val);
        }
        return $this->getConfig('url_prefix','').$page.($tmp?"&".join('&',$tmp):'');
    }
    function redirect($page=null,$args=array()){
        /**
         * Redirect to specified page. $args are $_GET arguments.
         * Use this function instead of issuing header("Location") stuff
         */

        header("Location: ".$this->getDestinationURL($page,$args));
        exit;
    }
    function isClicked($button_name){
        /**
         * Will return true if button with this name was clicked
         */
        return isset($_POST[$button_name])||isset($_POST[$button_name.'_x']);
    }
    function isAjaxOutput(){
        // TODO: chk, i wonder if you pass any arguments through get when in ajax mode. Well
        // if you do, then make a check here. Form_Field::displayFieldError relies on this.
        return false;
    }


    function initDefaults(){
        if(!defined('DTP'))define('DTP','');


        if($_GET['page']=="")$_GET['page']='Index';
        $this->page=$_GET['page'];

        $this->add('Logger');

        $this->initLayout();
    }
    function initLayout(){
        // This function adds layout of how the webpage looks like. It should be initializing
        // content of the page, sidebars and any other elements on the page. Different 
        // content pages are handled by page_*
        return $this
            ->addLayout('Content')
            ->addLayout('Menu')
            ->addLayout('LeftSidebar')
            ->addLayout('RightSidebar')
            ->addLayout('InfoWindow')
            ;
    }
    function addLayout($name){
        if(method_exists($this,$lfunc='layout_'.$name)){
            if($this->template->is_set($name)){
                $this->$lfunc();
            }
        }
        return $this;
    }
    function layout_Content(){
        // This function initializes content. Content is page-dependant

        if(method_exists($this,$pagefunc='page_'.$this->page)){
            $p=$this->add('Page',$this->page,'Content');
            $this->$pagefunc($p);
        }else{
            $this->add('page_'.$this->page,$this->page,'Content');
            //throw new BaseException("No such page: ".$this->page);
        }
    }
    function layout_LeftSidebar(){
        $this->template->del('LeftSidebar');
    }
    function layout_RightSidebar(){
        $this->template->del('RightSidebar');
    }
    function layout_InfoWindow(){
        $this->add('InfoWindow',null,'InfoWindow');//,'InfoWindow');
    }

    function page_Index($p){
        $p->add('LoremIpsum',null,'Content');
    }


    function outputInfo($msg){
        parent::outputInfo($msg);
        $this->info_messages[]=array('no'=>count($this->info_messages),'content'=>htmlspecialchars($msg),'backtrace'=>debug_backtrace());
    }

    function render(){
        /*
        if($this->info_messages && $this->template->is_set('page_top')){
            $info_box=$this->add('Container',null,'page_top','msgbox');
            $info_box->template->set('msgbox_title','Informative Messages');
            // since recursive render already been through childs... so..

            $messages=$info_box->add('CompleteArrayLister',null,'msgbox_content','info_messages');
            $messages->safe_html_output=false;
            $messages->data=$this->info_messages;

            $info_box->downCall('render');
        }
*/
        return parent::render();
    }
    function outputFatal($name,$shift=0){
        $this->hook('output-fatal',array($name,$shift+1));
        throw new BaseException("Fatal: ".$name,'fatal',$shift+1);
    }
}