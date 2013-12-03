<?php

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.controller');
jimport('joomla.filesystem.file');
//require_once (JPATH_COMPONENT.DS.'helpers'.DS.'imageselect.php');
require_once (JPATH_COMPONENT_SITE.DS.'helpers'.DS.'imageselect.php');

class sportsmanagementControllerImagehandler extends JController
{
	/**
	 * Constructor
	 *
	 * @since 0.9
	 */
	function __construct()
	{
		parent::__construct();

		// Register Extra task
	}

	/**
	 * logic for uploading an image
	 *
	 * @access public
	 * @return void
	 * @since 0.9
	 */
	function upload()
	{
		$mainframe	= JFactory::getApplication();
        $option = JRequest::getCmd('option');

		// Check for request forgeries
		JRequest::checkToken() or die( 'COM_SPORTSMANAGEMENT_GLOBAL_INVALID_TOKEN' );

		$file	= JRequest::getVar( 'userfile', '', 'files', 'array' );
		//$task	= JRequest::getVar( 'task' );
		$type	= JRequest::getVar( 'type' );
		$folder	= ImageSelectSM::getfolder($type);
		$field	= JRequest::getVar( 'field' );
		$linkaddress	= JRequest::getVar( 'linkaddress' );
		// Set FTP credentials, if given
		jimport( 'joomla.client.helper' );
		JClientHelper::setCredentialsFromRequest( 'ftp' );
		//$ftp = JClientHelper::getCredentials( 'ftp' );

		//set the target directory
		//$base_Dir = JPATH_SITE . DS . 'media' . DS . 'com_joomleague' . DS . $folder . DS;
		$base_Dir = JPATH_SITE . DS . 'images' . DS . $option . DS .'database'.DS. $folder . DS;
        
        $mainframe->enqueueMessage(JText::_($type),'');
        $mainframe->enqueueMessage(JText::_($folder),'');
        $mainframe->enqueueMessage(JText::_($base_Dir),'');

    //do we have an imagelink?
    if ( !empty( $linkaddress ) )
    {
    $file['name'] = basename($linkaddress);
    
if (preg_match("/dfs_/i", $linkaddress)) 
{
$filename = $file['name'];
}
else
{
    //sanitize the image filename
		$filename = ImageSelectSM::sanitize( $base_Dir, $file['name'] );
}

		
		$filepath = $base_Dir . $filename;
		
if ( !copy($linkaddress,$filepath) )
{
echo "<script> alert('".JText::_( 'COM_SPORTSMANAGEMENT_ADMIN_IMAGEHANDLER_COPY_FAILED' )."'); window.history.go(-1); </script>\n";
//$mainframe->close();
}
else
{
//echo "<script> alert('" . JText::_( 'COPY COMPLETE'.'-'.$folder.'-'.$type.'-'.$filename.'-'.$field ) . "'); window.history.go(-1); window.parent.selectImage_".$type."('$filename', '$filename','$field'); </script>\n";
echo "<script>  window.parent.selectImage_".$type."('$filename', '$filename','$field');window.parent.SqueezeBox.close(); </script>\n";
//$mainframe->close();
}

    
    }
    
		//do we have an upload?
		if ( empty( $file['name'] ) )
		{
			echo "<script> alert('".JText::_( 'COM_SPORTSMANAGEMENT_ADMIN_IMAGEHANDLER_CTRL_IMAGE_EMPTY' )."'); window.history.go(-1); </script>\n";
			//$mainframe->close();
		}

		//check the image
		$check = ImageSelectSM::check( $file );

		if ( $check === false )
		{
			$mainframe->redirect( $_SERVER['HTTP_REFERER'] );
		}

		//sanitize the image filename
		$filename = ImageSelectSM::sanitize( $base_Dir, $file['name'] );
		$filepath = $base_Dir . $filename;

		//upload the image
		if ( !JFile::upload( $file['tmp_name'], $filepath ) )
		{
			echo "<script> alert('".JText::_( 'COM_SPORTSMANAGEMENT_ADMIN_IMAGEHANDLER_CTRL_UPLOAD_FAILED' )."'); window.history.go(-1); </script>\n";
			//$mainframe->close();

		}
		else
		{
//			echo "<script> alert('" . JText::_( 'COM_SPORTSMANAGEMENT_ADMIN_IMAGEHANDLER_CTRL_UPLOAD_COMPLETE'.'-'.$folder.'-'.$type.'-'.$filename.'-'.$field ) . "'); window.history.go(-1); window.parent.selectImage_".$type."('$filename', '$filename','$field'); </script>\n";
//			echo "<script> alert('" . JText::_( 'COM_SPORTSMANAGEMENT_ADMIN_IMAGEHANDLER_CTRL_UPLOAD_COMPLETE' ) . "'); window.history.go(-1); window.parent.selectImage_".$type."('$filename', '$filename','$field'); </script>\n";
      echo "<script>  window.parent.selectImage_".$type."('$filename', '$filename','$field');window.parent.SqueezeBox.close(); </script>\n";
			//$mainframe->close();
		}

	}

	/**
	 * logic to mass delete images
	 *
	 * @access public
	 * @return void
	 * @since 0.9
	 */
	function delete()
	{
		$mainframe	= JFactory::getApplication();
        $option = JRequest::getCmd('option');
		// Set FTP credentials, if given
		jimport( 'joomla.client.helper' );
		JClientHelper::setCredentialsFromRequest( 'ftp' );

		// Get some data from the request
		$images	= JRequest::getVar( 'rm', array(), '', 'array' );
		$type	= JRequest::getVar( 'type' );

		$folder	= ImageSelectSM::getfolder( $type );

		if ( count( $images ) )
		{
			foreach ( $images as $image )
			{
				if ( $image !== JFilterInput::clean( $image, 'path' ) )
				{
					JError::raiseWarning( 100, JText::_( 'COM_SPORTSMANAGEMENT_ADMIN_IMAGEHANDLER_CTRL_UNABLE_TO_DELETE' ) . ' ' . htmlspecialchars( $image, ENT_COMPAT, 'UTF-8' ) );
					continue;
				}

				$fullPath = JPath::clean( JPATH_SITE . DS . 'images' . DS . $option . DS .'database'.DS. $folder . DS . $image );
				$fullPaththumb = JPath::clean( JPATH_SITE . DS . 'images' . DS . $option . DS .'database'.DS. $folder . DS . 'small' . DS . $image );
				if ( is_file( $fullPath ) )
				{
					JFile::delete( $fullPath );
					if ( JFile::exists( $fullPaththumb ) )
					{
						JFile::delete( $fullPaththumb );
					}
				}
			}
		}

		$mainframe->redirect( 'index.php?option='.$option.'&view=imagehandler&type=' . $type . '&tmpl=component' );
	}

}
?>