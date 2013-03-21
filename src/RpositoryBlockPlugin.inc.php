<?php
import('lib.pkp.classes.plugins.BlockPlugin');

class RpositoryBlockPlugin extends BlockPlugin {
    /**
    * Install default settings on journal creation.
    * @return string
    */
    function getContextSpecificPluginSettingsFile(){
        return $this->getPluginPath() . '/settings.xml';
    }
    
   /**
     * Get the display name of this plugin.
     * @return String
     */
    function getDisplayName() {
            return "RpositoryBlock";
    }

    /**
     * Get a description of the plugin.
     */
    function getDescription() {
            return "RpositoryBlock Plugin";
    }
    
    function curPageURL(){
        $pageURL = 'http';
        if($_SERVER["HTTPS"] == "on"){
            $pageURL .= "s";
        }
        $pageURL .= "://";
        if($_SERVER["SERVER_PORT"] != "80"){
            $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
            }
            else{
                $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
            }
        return $pageURL;
    }
        
    
    function getContents(&$templateMgr){
        $daos    =& DAORegistry::getDAOs();
        $rpositoryDao  =& $daos['RpositoryDAO'];
        $context = $this->curPageURL();
        $pattern = '#.*/index.php/[^/]*/article/view/[0-9]+#';
        $articleId = NULL;
        
        if(preg_match($pattern , $context)){
	    $templateMgr->assign('isArticleView', 1);
            $pos = strrpos($context , '/view/');
            $articleId = substr($context , $pos + 6);
            if($pos = strpos($articleId, '/')){
                $articleId = substr($articleId, 0, $pos);
            }
        } else {
	    $templateMgr->assign('isArticleView', 0);
	}
        if($articleId){
            $pidv1 = $rpositoryDao->getPIDv1($articleId);
            $pidv2 = $rpositoryDao->getPIDv2($articleId);
        }
        $templateMgr->assign('pidv1', $pidv1);
        $templateMgr->assign('pidv2', $pidv2);
	$templateMgr->assign('rpositoryBase', "/Rpository/src/contrib/");
	$filename = $rpositoryDao->getRPackageFile($articleId);
	error_log("OJS - ".$filename);
	$templateMgr->assign('fileName', $filename);
	$templateMgr->assign('packageName', str_replace('_1.0.tar.gz', '', $filename));
        return parent::getContents($templateMgr);
    }


}
?>
