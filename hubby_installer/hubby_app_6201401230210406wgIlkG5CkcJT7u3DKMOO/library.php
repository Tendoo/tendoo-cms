<?php
class hubby_contact_handler_class
{
	public function __construct()
	{
		__extends($this);
	}
	public function toogleFields($name = false,$email = false,$phone = false,$website = false,$country	=	false,$city = false)
	{
		$query	=	$this->db->get('hubby_contact_handler_option');
		$fields	=	array(
			'SHOW_NAME'		=>	$name == true ? 1 : 0,
			'SHOW_MAIL'		=>	$email== true ? 1 : 0,
			'SHOW_PHONE'	=>	$phone== true ? 1 : 0,
			'SHOW_COUNTRY'	=>	$country == true ? 1 : 0,
			'SHOW_CITY'		=>	$city == true ? 1 : 0,
			'SHOW_WEBSITE'	=>	$website == true ? 1 : 0
		);
		if(count($query->result_array()) > 0)
		{
			return $this->db->where('ID',1)->update('hubby_contact_handler_option',$fields);
		}
		else
		{
			return $this->db->insert('hubby_contact_handler_option',$fields);
		}
	}
	public function getToggledFields()
	{
		$query	=	$this->db->get('hubby_contact_handler_option');
		return $query->result_array();
	}
	public function addContact($type,$content)
	{
		return $this->db->insert('hubby_contact_fields',array(
			'CONTACT_TYPE'		=>	$type,
			'CONTACT_TEXT'		=>	$content
		));
	}
	public function removeContact($id)
	{
		return $this->db->where('ID',$id)->delete('hubby_contact_fields');
	}
	public function getContact()
	{
		$query	=	$this->db->get('hubby_contact_fields');
		return $query->result_array();
	}
	public function addDescription($content)
	{
		$query	=	$this->db->get('hubby_contact_aboutUs');
		$array	=	array(
			'FIELD_CONTENT'		=>		$content,
			'AUTHOR'			=>		$this->users_global->current('ID'),
			'DATE'				=>		$this->hubby->datetime()
		);
		if(count($query->result_array()) > 0)
		{
			return $this->db->update('hubby_contact_aboutUs',$array);
		}
		else
		{
			return $this->db->insert('hubby_contact_aboutUs',$array);
		}
	}
	public function getDescription()
	{
		$query	=	$this->db->get('hubby_contact_aboutUs');
		return $query->result_array();
	}
	// Common
	public function pushContact($userid,$username,$content,$email,$phone,$website,$country,$city)
	{
		if($this->users_global->isConnected())
		{
			$userid			=	$this->users_global->current('ID');
			$username		=	$this->users_global->current('PSEUDO');
		}
		else
		{
			$userid			=	0;
		}
		$date	=	$this->hubby->datetime();
		return $this->db->insert('hubby_contact_handler',array(
			'USER_ID'			=>	$userid,
			'USER_NAME'			=>	$username,
			'USER_MAIL'			=>	$email,
			'USER_PHONE'		=>	$phone,
			'USER_WEBSITE'		=>	$website,
			'USER_COUNTRY'		=>	$country,
			'USER_CITY'			=>	$city,
			'USER_CONTENT'		=>	$content,
			'DATE'				=>	$date,
		));
	}
	public function getSendedContact($start = null,$end = null)
	{
		if(is_numeric($start) && $end == null)
		{
			$this->db->where('ID',$start)->update('hubby_contact_handler',array('STATE'=>1));
			$this->db->where('ID',$start);
		}
		else if(is_numeric($start) && is_numeric($end))
		{
			$this->db->order_by('ID','desc');
			$this->db->limit($end,$start);
		}
		$query	=	$this->db->get('hubby_contact_handler');
		return $query->result_array();
	}
	public function deleteContact($id)
	{
		$contact			=	$this->getSendedContact($id);
		if($contact)
		{
			return $this->db->where('ID',$id)->delete('hubby_contact_handler');
		}
		return false;
	}
}