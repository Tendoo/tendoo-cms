<?php
class Hubby
{
	private $siteState;
	private $coreDir;
	private $defaultTitle;
	private $defaultDesc;
	private $isInstalled;
	private $data;
	protected	$load;
	protected	$instance;
	private 	$db;
	
	public function __construct()
	{
		$this->core		=	Controller::instance();
		$this->load			=	$this->core->load;
		$this->defaultTitle = 'Page Sans Titre - Hubby';
		$this->defaultDesc	= 'Page sans description - Hubby';
		if(is_file('hubby_core/config/hubby_config.php'))
		{
			$this->isInstalled =  true;
		}
		else
		{
			$this->isInstalled = false;
		}
	}
	public function isInstalled()
	{
		return $this->isInstalled;
	}
	public function createTables()
	{
		$this->core		=	Controller::instance();
		$config			=	$_SESSION['db_datas'];
		$this->core->db	=	DB($config,TRUE);
		/* CREATE hubby_controllers */
		$sql = 
		'CREATE TABLE IF NOT EXISTS `hubby_controllers` (
		  `ID` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
		  `PAGE_NAMES` varchar(40) NOT NULL,
		  `PAGE_CNAME` varchar(40) NOT NULL,
		  `PAGE_MODULES` text,
		  `PAGE_TITLE` varchar(40) NOT NULL,
		  `PAGE_DESCRIPTION` text,
		  `PAGE_MAIN` varchar(5) DEFAULT NULL,
		  `PAGE_VISIBLE` varchar(5) NOT NULL,
		  PRIMARY KEY (`ID`)
		) ENGINE=InnoDB;';
		if(!$this->core->db->query($sql))
		{
			return false;
		};
		/* CREATE hubby_modules */
		$sql = 
		'CREATE TABLE IF NOT EXISTS `hubby_modules` (
		  `ID` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
		  `NAMESPACE` varchar(40) NOT NULL,
		  `HUMAN_NAME` varchar(100) NOT NULL,
		  `AUTHOR` varchar(100) DEFAULT NULL,
		  `DESCRIPTION` text,
		  `PRIORITY` int(11) DEFAULT NULL,
		  `TYPE` varchar(50) DEFAULT NULL,
		  `ACTIVE` varchar(50) DEFAULT NULL,
		  `HUBBY_VERS` varchar(100) NOT NULL,
		  `ENCRYPTED_DIR` text,
		  PRIMARY KEY (`ID`)
		) ENGINE=InnoDB;';
		if(!$this->core->db->query($sql))
		{
			return false;
		};
		/* CREATE hubby_options */
		$sql = 
		'CREATE TABLE IF NOT EXISTS `hubby_options` (
		  `ID` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
		  `SITE_NAME` varchar(40) NOT NULL,
		  `SITE_TYPE` varchar(40) NOT NULL,
		  `SITE_LOGO` varchar(200) NOT NULL,
		  `SITE_TIMEZONE` varchar(10) NOT NULL,
		  `SITE_TIMEFORMAT` varchar(10) NOT NULL,
		  `SHOW_WELCOME` varchar(10) NOT NULL,
		  PRIMARY KEY (`ID`)
		) ENGINE=InnoDB;';
		if(!$this->core->db->query($sql))
		{
			return false;
		};
		/* CREATE hubby_themes */
		$sql = 
		'CREATE TABLE IF NOT EXISTS `hubby_themes` (
		  `ID` int(11) NOT NULL AUTO_INCREMENT,
		  `NAMESPACE` varchar(100) NOT NULL,
		  `HUMAN_NAME` varchar(200) NOT NULL,
		  `AUTHOR` varchar(100) NOT NULL,
		  `DESCRIPTION` text NOT NULL,
		  `ACTIVATED` varchar(20) NOT NULL,
		  `HUBBY_VERS` varchar(100) NOT NULL,
		  `ENCRYPTED_DIR` text NOT NULL,
		  PRIMARY KEY (`ID`)
		) ENGINE=InnoDB;';
		if(!$this->core->db->query($sql))
		{
			return false;
		};
		/* CREATE hubby_users */
		$sql = 
		'CREATE TABLE IF NOT EXISTS `hubby_users` (
		  `ID` int(11) NOT NULL AUTO_INCREMENT,
		  `PSEUDO` varchar(100) NOT NULL,
		  `PASSWORD` varchar(100) NOT NULL,
		  `NAME` varchar(100) NOT NULL,
		  `SURNAME` varchar(100) NOT NULL,
		  `EMAIL` varchar(100) NOT NULL,
		  `SEX` varchar(50) NOT NULL,
		  `STATE` varchar(100) NOT NULL,
		  `PHONE` varchar(100) NOT NULL,
		  `TOWN` varchar(100) NOT NULL,
		  `REG_DATE` datetime NOT NULL,
		  `LAST_ACTIVITY` datetime NOT NULL,
		  `PRIVILEGE` varchar(100) NOT NULL,
		  `ACTIVE` varchar(100) NOT NULL,
		  PRIMARY KEY (`ID`)
		) ENGINE=InnoDB;';
		if(!$this->core->db->query($sql))
		{
			return false;
		};
		/// MESSAGING TABLE create `hubby_users_messaging_content`
		$sql = 
		'CREATE TABLE IF NOT EXISTS `hubby_users_messaging_content` (
		  `ID` int(11) NOT NULL AUTO_INCREMENT,
		  `MESG_TITLE_REF` int(11) NOT NULL,
		  `CONTENT` text NOT NULL,
		  `AUTHOR` int(11) NOT NULL,
		  `DATE` datetime NOT NULL,
		  PRIMARY KEY (`ID`)
		) ENGINE=InnoDB;';
		if(!$this->core->db->query($sql))
		{
			return false;
		};
		
		/// ADMIN PRIVILEGE TABLE create  `hubby_admin_privileges`
		$sql = 
		'CREATE TABLE IF NOT EXISTS `hubby_admin_privileges` (
		  `ID` int(11) NOT NULL AUTO_INCREMENT,
		  `HUMAN_NAME` varchar(100) NOT NULL,
		  `DESCRIPTION` text NOT NULL,
		  `DATE` datetime NOT NULL,
		  `PRIV_ID` varchar(100) NOT NULL,
		  PRIMARY KEY (`ID`)
		) ENGINE=InnoDB;
		;';
		if(!$this->core->db->query($sql))
		{
			return false;
		};
		/// ADMIN PRIVILEGE TABLE create  `hubby_privileges_actions`
		$sql = 
		'CREATE TABLE IF NOT EXISTS `hubby_privileges_actions` (
		  `ID` int(11) NOT NULL AUTO_INCREMENT,
		  `TYPE_NAMESPACE` varchar(200) NOT NULL,
		  `REF_TYPE_ACTION` varchar(100) NOT NULL,
		  `REF_ACTION_VALUE` varchar(100) NOT NULL,
		  `REF_PRIVILEGE` varchar(11) NOT NULL,
		  PRIMARY KEY (`ID`)
		) ENGINE=InnoDB;';
		if(!$this->core->db->query($sql))
		{
			return false;
		};
		// Create `hubby_modules_actions`
		$sql = 
		'CREATE TABLE IF NOT EXISTS `hubby_modules_actions` (
		  `ID` int(11) NOT NULL AUTO_INCREMENT,
		  `MOD_NAMESPACE` varchar(200) NOT NULL,
		  `ACTION` varchar(100) NOT NULL,
		  `ACTION_NAME` varchar(100) NOT NULL,
		  `ACTION_DESCRIPTION` varchar(200) NOT NULL,
		  PRIMARY KEY (`ID`)
		) ENGINE=InnoDB;';
		if(!$this->core->db->query($sql))
		{
			return false;
		};
		// Create `hubby_modules_actions`
		$sql = 
		'CREATE TABLE IF NOT EXISTS `hubby_users_messaging_title` (
		  `ID` int(11) NOT NULL AUTO_INCREMENT,
		  `AUTHOR` int(11) NOT NULL,
		  `RECEIVER` int(11) NOT NULL,
		  `CREATION_DATE` datetime NOT NULL,
		  `STATE` int(11) NOT NULL,
		  PRIMARY KEY (`ID`)
		) ENGINE=InnoDB;';
		if(!$this->core->db->query($sql))
		{
			return false;
		};
		
		return true;
	}
	public function connectToDb()
	{
		if(is_file(SYSTEM_DIR.'config/hubby_config.php'))
		{
			include_once(SYSTEM_DIR.'config/hubby_config.php');
			$this->core->db	=	DB($db,TRUE);
			return $this->core->db->conn_id;
		}
		else
		{
			return FALSE;
		}
	}
	public function createConfigFile()
	{
		/* CREATE CONFIG FILE */
		$config			=	$_SESSION['db_datas'];
		$string_config = 
		"<?php
		\$db['hostname'] = '".$config['hostname']."';
		\$db['username'] = '".$config['username']."';
		\$db['password'] = '".$config['password']."';
		\$db['database'] = '".$config['database']."';
		\$db['dbdriver'] = '".$config['dbdriver']."';
		\$db['dbprefix'] = '';
		\$db['pconnect'] = FALSE;
		\$db['db_debug'] = TRUE;
		\$db['cache_on'] = FALSE;
		\$db['cachedir'] = '';
		\$db['char_set'] = 'utf8';
		\$db['dbcollat'] = 'utf8_general_ci';
		\$db['swap_pre'] = '';
		\$db['autoinit'] = TRUE;
		\$db['stricton'] = FALSE;";
		$file = fopen('hubby_core/config/hubby_config.php','w+');
		fwrite($file,$string_config);
		fclose($file);	
	}
	public function attemptConnexion($host,$user,$pass,$db_name,$type)
	{
		$this->core		=	Controller::instance();
		$config['hostname'] = $host;
		$config['username'] = $user;
		$config['password'] = $pass;
		$config['database'] = $db_name;
		$config['dbdriver'] = $type;
		$config['dbprefix'] = "";
		$config['pconnect'] = TRUE;
		$config['db_debug'] = TRUE;
		$config['cache_on'] = FALSE;
		$config['cachedir'] = "";
		$config['char_set'] = "utf8";
		$config['dbcollat'] = "utf8_general_ci";
		$config['autoinit'] = TRUE;
		$config['stricton'] = FALSE;
		$this->core->db		=	DB($config,TRUE);
		$this->connexion_status	=	$this->core->db->initialize();
		if($this->connexion_status === TRUE)
		{
			$_SESSION['db_datas']	=	$config;
			return true;
		}
		$this->core->notice->push_notice(notice($this->connexion_status));
		return false;
	}
	public function setOptions($name)
	{
		$q = $this->core->db->get('hubby_options');
		$r = $q->result();
		if(count($r) == 1)
		{	
			$value['SITE_NAME'] 			= $name;
			$values['SHOW_WELCOME']			=	'TRUE';
			$this->core->db->where('ID',1);
			$result = $this->core->db->update('hubby_options',$value);
		}
		else if(count($r) == 0)
		{
			$value['SITE_NAME'] 			= 	$name;
			$values['SHOW_WELCOME']			=	'TRUE';
			$result = $this->core->db->insert('hubby_options',$value);
		}
		if($result == false)
		{
			return false;
		}
		// CREATING FIRST CONTROLLERS
		return $this->firstController('Accueil','home','',$value['SITE_NAME'].' - Accueil','Aucune description enregistr&eacute;e','TRUE','TRUE');
	}
	public function firstController($name,$cname,$mod,$title,$description,$main,$visible)
	{
		$this->core	->db->select('*')
					->from('hubby_controllers');
		$query		=	$this->core->db->get();
		if($query->num_rows == 0)
		{
			$e['PAGE_CNAME']		=	strtolower($cname);
			$e['PAGE_NAMES']		=	strtolower($name);
			$e['PAGE_TITLE']		=	$title;
			$e['PAGE_DESCRIPTION']	=	$description;
			$e['PAGE_MAIN']			=	$main;
			$e['PAGE_MODULES']		=	$mod;
			$e['PAGE_VISIBLE']		=	$visible;
			return $this->core			->db->insert('hubby_controllers',$e);			
		}
		return false;
	}
	public function getSiteTheme()
	{
		$query	=	$this->core->db->where('ACTIVATED','TRUE')->get('hubby_themes');
		$data	=	$query->result_array();
		if(array_key_exists(0,$data))
		{
			return $data[0];
		}
		else
		{
			return false;
		}
	}
	public function getOptions()
	{
		$this->core->db->select('*')
					->from('hubby_options')
					->where('ID',1);
		$r			=	$this->core->db->get();
		return $r->result_array();
	}
	public function getPage($page = 'index')
	{
		if($page == 'index')
		{
			$this->core->db->select('*')
						->from('hubby_controllers')
						->where('PAGE_MAIN','TRUE');
			$data 		=	$this->core->db->get();
			$value		=	$data->result_array();
			if(count($value) == 1)
			{
				return $value;					
			}
			return 'noMainPage';
		}
		else
		{
			$this->core->db->select('*')
						->from('hubby_controllers')
						->where('PAGE_CNAME',$page);
			$data		= 	$this->core->db->get();
			$value		=	$data->result_array();
			if(count($value) == 1)
			{
				return $value;
			}
			else
			{
				return 'page404';
			}
		}
	}
	public function getControllers()
	{
		$this->core->db->select('*')
					->from('hubby_controllers')->where('PAGE_VISIBLE','TRUE');
		$r			=	$this->core->db->get();
		return $r->result_array();
	}
	/// MODULES LOADER
	public function getGlobalModules() // Récupération de tous les modules de type GLOBAL
	{
		$query	=	$this->core->db	->where('TYPE','GLOBAL')
									->get('hubby_modules');
		$data	=	$query->result_array();
		if(count($data) > 0)
		{
			return $data;
		}
		return false;
	}
	public function getSpeModule($id,$option =	TRUE) // Obsolete Transit
	{
		return $this->getSpeMod($id,$option);
	}
	public function getSpeMod($value,$option = TRUE)
	{
		$this->core->db		->select('*')
							->from('hubby_modules');
		if($option == TRUE)
		{
			$this->core->db->where('ID',$value);
		}
		else
		{
			$this->core->db->where('NAMESPACE',$value);
		}
							
		$query				= $this->core->db->get();
		$data				=	 $query->result_array();
		if(count($data) > 0)
		{
			return $data;
		}
		return false;		
	}
	public function getSpeModuleByNamespace($namespace)
	{
		$this->core->db		->select('*')
							->from('hubby_modules')
							->where('NAMESPACE',$namespace);
		$query				= $this->core->db->get();
		$data				= $query->result_array();
		if(count($data) > 0)
		{
			return $data;
		}
		return false;
	}
	public function isInstall()
	{
		return $this->isInstalled;
	}
	public function setTitle($e)
	{
		$this->defaultTitle = $e;
	}
	public function getTitle()
	{
		return $this->defaultTitle;
	}
	public function setDescription($e)
	{
		$this->defaultDesc	=	$e;
	}
	public function getDescription()
	{
		return $this->defaultDesc;
	}
	/* INNER FUNCTION */
	public function loadModules() /// OBSOLETE
	{
		$modules= array();
		if($dir	=	opendir('application/views/modules'))
		{
			while(($file = readdir($dir)) !== FALSE)
			{
				if(!in_array($file,array('.','..')))
				{
					$modules[]	=	new Modules($file);
				}
			}
			return $modules;
		}
		return false;
	}
	public function modules_url($e)
	{
		return site_url();
	}
	public function retreiveControlerUrl()
	{
		$details	=	$this->core->url->http_request(TRUE);
		if(array_key_exists(0,$details))
		{
			$controller	=	$this->getPage();
			if(is_array($controller))
			{
				return $this->core->url->site_url(array($controller[0]['PAGE_CNAME']));
			}
			return $controller;
		}
	}
	public function time($timestamp	=	'',$toArray	=	false)
	{
		$timestamp	=	strtotime($timestamp);
		$this->load->helper('date');
		$options	=	$this->getOptions();
		$timezone	=	$options[0]['SITE_TIMEZONE'];
		$timeformat	=	$options[0]['SITE_TIMEFORMAT'];
		if($timezone== '')
		{
			$timezone 		= 'UTC';
		}
		if($timeformat	==	'')
		{
			$timeformat		=	'type_1';
		}
		$daylight_saving 	= TRUE;
		if($timestamp	==	'')
		{
			$timestamp				=	gmt_to_local(time(), $timezone, $daylight_saving);
		}
		if($toArray	==	true)
		{
			return array(
				'd'=>mdate('%d',$timestamp),
				'y'=>mdate('%Y',$timestamp),
				'M'=>mdate('%m',$timestamp),
				'h'=>mdate('%h',$timestamp),
				'i'=>mdate('%i',$timestamp),
				's'=>mdate('%s',$timestamp)
			);
		}
		if($timeformat 	==	'type_1')
		{
			return mdate('%d %m %Y - %h:%i %s',$timestamp);
		}
		elseif($timeformat 	==	'type_2')
		{
			return mdate('%d/%m/%Y, - %h:%i %s',$timestamp);
		}
		elseif($timeformat 	==	'type_3')
		{
			return mdate('%Y/%m/%d - %h:%i %s',$timestamp);
		}
	}
	public function arrayToTimestamp($date)
	{
		return strtotime($date['y'].'-'.$date['M'].'-'.$date['d'].' '.$date['h'].':'.$date['i'].':'.$date['s']);
	}
	public function timestamp()
	{
		$this->load->helper('date');
		$options	=	$this->getOptions();
		$timezone	=	$options[0]['SITE_TIMEZONE'];
		if($timezone== '')
		{
			$timezone 		= 'UTC';
		}
		$daylight_saving 	= TRUE;
		$timestamp				=	gmt_to_local(time(), $timezone, $daylight_saving);
		return $timestamp;
	}
	public function timespan($timestamp)
	{
		return timespan($timestamp,$this->timestamp());
	}
	public function datetime()
	{
		$this->load->helper('date');
		$options	=	$this->getOptions();
		$timezone	=	$options[0]['SITE_TIMEZONE'];
		if($timezone== '')
		{
			$timezone 		= 'UTC';
		}
		$daylight_saving 	= TRUE;
		$timestamp				=	gmt_to_local(time(), $timezone, $daylight_saving);
		$datetime	=	mdate('%Y-%m-%d %h:%i:%s',$timestamp);
		return $datetime;
	}
	public function urilizeText($text)
	{
		if(!function_exists('stripThing'))
		{
			function stripThing($delimiter,$offset)
			{
				$newtext	=	explode($delimiter,$offset);
				$e = '';
				for($i = 0;$i < count($newtext) ; $i++)
				{
					if($i+1 == count($newtext))
					{
						$e .=$newtext[$i];
					}
					else
					{
						$e .=$newtext[$i].'-';
					}
				}
				return $newtext	=	strtolower($e);
			}
		}
		$this->load->helper('text');
		$newtext	=	convert_accented_characters($text);
		$newtext	=	stripThing('\'',$newtext);
		$newtext	=	stripThing(' ',$newtext);
		return $newtext;
	}
	// HTML FUNCTION
	private $loaded_editor;
	public function loadEditor($id=1)
	{
		$this->loaded_editor	=	$id;
		if($id == 1)
		{
			$this->core->file->js_push('tiny_mce/tiny_mce');
		}
		else if($id == 2)
		{
			$this->core->file->css_push('elrte/css/elrte.full');
			$this->core->file->css_push('elrte/css/elrte-inner');
			$this->core->file->css_push('elrte/jquery-ui-1.8.13.custom');
			/*-------------------------------------------------------------*/
			$this->core->file->js_push('elrte/js/jquery-ui-1.8.13.custom.min');
			$this->core->file->js_push('elrte/js/elrte.min');
		}
		else if($id	==	3)
		{
			$this->core->file->js_push('ckeditor/ckeditor');
		}
	}
	public function getEditor($values)
	{
		$default	=	array(
			'id'			=>null,
			'width'			=>900,
			'height'		=>300,
			'cssclass'		=>'tinyeditor',
			'controlclass'	=>'tinyeditor-control',
			'rowclass'		=>'tinyeditor-header',
			'dividerclass'	=>'tinyeditor-divider',
			'controls'		=>array('bold', 'italic', 'underline', 'strikethrough', '|', 'subscript', 'superscript', '|',
				'orderedlist', 'unorderedlist', '|', 'outdent', 'indent', '|', 'leftalign',
				'centeralign', 'rightalign', 'blockjustify', '|', 'unformat', '|', 'undo', 'redo', 'n',
				'font', 'size', 'style', '|', 'image', 'hr', 'link', 'unlink', '|', 'print'),
			'footer'		=>'true',
			'fonts'			=>array('Verdana','Arial','Georgia','Trebuchet MS'),
			'xhtml'			=>'true',
			'cssfile'		=>'custom.css',
			'bodyid'		=>'editor',
			'footerclass'	=>'tinyeditor-footer',
			'toggle'		=>array('text'=>'source','activetext'=>'wysiwyg','cssclass'=>'toggle'),
			'resize'		=>array('cssclass'=>'resize'),
			'defaultValue'	=>''		
		);
		$default			=	array_merge($default,$values);
		if(array_key_exists('defaultValue',$default))
		{
			$defValue	=	$default['defaultValue'];
		}
		else
		{
			$defValue	=	'';
		}
		switch($this->loaded_editor)
		{
			case 1 :
			return "
			<textarea name=".$default['name']." id=".$default['id']." style=\"width:".$default['width']."px;height:".$default['height']."px;\">".$default['defaultValue']."</textarea>
			<script type=\"text/javascript\">
			tinyMCE.init({
					mode : 'textareas',
					theme:'advanced',
					plugins : 'autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,iespell,inlinepopups,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,xhtmlxtras,template,advlist',
					theme_advanced_buttons1 : 'save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect',
					theme_advanced_buttons3_add:'emotions',
					theme_advanced_buttons2 : 'cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor',
					theme_advanced_buttons3 : 'tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,iespell,advhr,|,print,|,ltr,rtl,|,fullscreen',
					theme_advanced_buttons4 : '|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak',
					theme_advanced_toolbar_location : 'top',
					theme_advanced_toolbar_align : 'left',
					theme_advanced_statusbar_location : 'bottom'
			});
			</script>";;
			case 2 :
			return "
			<script type=\"text/javascript\">
				$().ready(function() {
					var opts = {
					cssClass : 'el-rte',
					//lang     : 'en',
					height   : 350,
	
					toolbar  : 'maxi', // custom
					cssfiles : ['elrte/css/elrte-inner.css', 'elrte/css/inner-example.css']
					}
					$('#editor').elrte(opts);
				})
			</script>
			<textarea name=\"".$values['name']."\" id=\"".$values['id']."\">".$defValue."</textarea>
			";
			break;
			case 3	:
			return "<textarea class=\"ckeditor\" name=\"".$values['name']."\" id=\"".$values['id']."\">".$defValue."</textarea>";
			break;
		}
	}
	// HUBBY_VERSION
	public function getVersion()
	{
		return 'Hubby - CMS('.$this->getVersId().')';
	}
	public function getVersId()
	{
		return HUBBY_VERSION;
	}
	public function presentation()
	{
		include(SYSTEM_DIR.'presentation.php');
	}
	public function interpreter($Class,$Method,$Parameters,$Init = NULL)
	{
		if($Init == NULL)
		{
			eval('$objet	= new '.$Class.'();'); // Création de l'objet
		}
		else
		{
			eval('$objet	= new '.$Class.'($Init);'); // Création de l'objet
		}
		if(method_exists($objet,$Method))
		{
			$param_text		=	'';
			$i = 0;
			foreach($Parameters as $p)
			{
				if($p != '') // Les parametres vide ne sont pas accepté
				{
					if($i+1 < count($Parameters))
					{
						$param_text .= '"'.$p.'",';
					}
					else
					{
						$param_text .= '"'.$p.'"';
					}
				}
				$i++;
			}			
			eval('$BODY 	=	$objet->'.$Method.'('.$param_text.');'); // exécution du controller.
			return $BODY;
		}
		else
		{
			return '404';
		}
	}
	public function error($array)
	{
		$this->setTitle('Erreur');
		$this->core->load->library('file');
		$this->core->file->css_push('hubby_global');
		$this->core->file->css_push('hubby_default');
		$error	=	strip_tags(notice($array));
		
		include_once(VIEWS_DIR.'warning.php');
	}
	public function show_error($error,$heading)
	{
		$this->setTitle('Erreur - '.$heading);
		$this->core->load->library('file');
		$this->core->file->css_push('hubby_global');
		$this->core->file->css_push('hubby_default');
		include_once(VIEWS_DIR.'warning.php');
	}
	public function paginate($elpp,$ttel,$pagestyle,$classOn,$classOff,$current_page,$baselink,$ajaxis_link=null)
	{
		/*// Gloabl ressources Control*/
		if(!is_finite($elpp))				: echo '<strong>$elpp</strong> is not finite'; return;
		elseif(!is_finite($pagestyle))		: echo '<strong>$pagestyle</strong> is not finite'; return;
		elseif(!is_finite($current_page))	: echo '<strong>$current_page</strong> is not finite'; return;
		endif;
		
		$more	=	array();
		if($pagestyle == 1)
		{
			$ttpage = ceil($ttel / $elpp);
			if(($current_page > $ttpage || $current_page < 1) && $ttel > 0): return array('',null,null,false,$more);
			endif;
			$firstoshow = ($current_page - 1) * $elpp;
			/*// FTS*/
			if($current_page < 5):$fts = 1;
			elseif($current_page >= 5):$fts = $current_page - 4;
			endif;
			/*// LTS*/
			if(($current_page + 4) <= $ttpage):$lts = $current_page + 4;
			/*elseif($ttpage > 5):$lts = $ttpage - $current_page;*/
			else:$lts = $ttpage;
			endif;
			
			$content = null;
			for($i = $fts;$i<=$lts;$i++)
			{
				$more[]	=	array(
					'link'	=>	$baselink.$i,
					'text'	=>	$i,
					'state'	=>	((int)$i === (int)$current_page) ? $classOn : $classOff // Fixing int type 03.11.2013
				);
				static $content = 'Page :';
				if($i == $fts && $i != 1): $content = $content.'<span style="margin:0 2px">...</span>';endif;
				if($current_page == $i)
				{
				$content = $content.'<span style="margin:0 2px">'.$i.'</span>';
				}
				else
				{
					if($ajaxis_link != null)
					{
						$content = $content.'<a ajaxis_link="'.$ajaxis_link.$i.'" href="'.$baselink.$i.'" class="'.$classOn.'" style="margin:0 2px" title="Aller &agrave; la page '.$i.'">'.$i.'</a>';
					}
					else
					{
						$content = $content.'<a href="'.$baselink.$i.'" class="'.$classOn.'" style="margin:0 2px" title="Aller &agrave; la page '.$i.'">'.$i.'</a>';
					}
				}
				if($i == $lts && $i != $ttpage):$content = $content.'<span style="margin:0 2px">...</span>';endif;
			}		
			return array($content,$firstoshow,$elpp,true,$more);
		}
		else if($pagestyle == 2)
		{
			$ttpage = ceil($ttel / $elpp);
			if($current_page > $ttpage || $current_page < 1): return array('',null,null,false);endif;
			$firstoshow = ($current_page - 1) * $elpp;
			if($current_page == 1)
			{
				$content['Precedent'] = '<a class="'.$classOff.'">Pr&eacute;c&eacute;dent</a>';
			}
			else if($current_page > 1)
			{
				if($ajaxis_link != null)
				{
					$content['Precedent'] = '<a ajaxis_link="'.$ajaxis_link.($current_page-1).'" href="'.$baselink.($current_page-1).'" class="'.$classOn.'">Pr&eacute;c&eacute;dent</a>';
				}
				else
				{
					$content['Precedent'] = '<a href="'.$baselink.($current_page-1).'" class="'.$classOn.'">Pr&eacute;c&eacute;dent</a>';
				}
			}
			if($current_page == $ttpage)
			{
				$content['Suivant']		= '<a class="'.$classOff.'">Suivant</a>';
			}
			else if($current_page < $ttpage)
			{
				if($ajaxis_link != null)
				{
					$content['Suivant']		= '<a ajaxis_link="'.$ajaxis_link.($current_page+1).'" class="'.$classOn.'" href="'.$baselink.($current_page+1).'">Suivant</a>';
				}
				else
				{
					$content['Suivant']		= '<a class="'.$classOn.'" href="'.$baselink.($current_page+1).'">Suivant</a>';
				}
			}
			/*// Debug*/
			/*echo 'Frist To Show: '.$fts.'<br>';
			echo 'Current Page: '.$current_page.'<br>';
			echo 'Last To Show: '.$lts.'<br>';*/
			return array($content,$firstoshow,$elpp,true);
		}
	}
}