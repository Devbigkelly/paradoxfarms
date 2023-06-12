<?php
class Matrix2x extends CI_Model {
	function __construct(){
		
        parent::__construct();
    }
	public function user_has_childs($username){
		$this->db->select('id');
		$this->db->from('binary_2x');
		$this->db->group_start();
		$this->db->where('binary_referral', $username);
		$this->db->or_where('direct_referral', $username);
		$this->db->group_end();
		$data = $this->db->get()->result_array();
		if (count($data)>0){
			return true;
		} else {
			return false;
		}
	}
	public function view_block($username){
		$block = '';
		$block .= '<div class="dg_img_div"><a href="'.base_url('member/referrals/genealogy/'.$username).'"><img class="'.$this->gen_color($username).'" src="'.$this->user_account->get_pic($username, 'small').'"></a></div>';
		$block .= '<span class="dg_username">'.$username.'</span>';
		return $block;
	}
	public function direct_genealogy($username){
		$childs = $this->direct_childs($username);
		$response = '';
		if (count($childs)>0){
			$response = '<ul id="direct_genealogy">';
			$response .= '<li>';
			$response .= $this->view_block($username);
			$response .= '<ul>';
			foreach ($childs as $child){
				$response .= '<li>';
				$response .= $this->view_block($child);
				$childs1 = $this->direct_childs($child);
				if (count($childs1)>0){
					$response .= '<ul>';
					foreach ($childs1 as $child1){
						$response .= '<li>';
						$response .= $this->view_block($child1);
						$childs2 = $this->direct_childs($child1);
						if (count($childs2)>0){
							$response .= '<ul>';
							foreach ($childs2 as $child2){
								$response .= '<li>';
								$response .= $this->view_block($child2);
								$childs3 = $this->direct_childs($child2);
								if (count($childs3)>0){
									$response .= '<ul>';
									foreach ($childs3 as $child3){
										$response .= '<li>';
										$response .= $this->view_block($child3);
										$childs4 = $this->direct_childs($child3);
										if (count($childs4)>0){
											$response .= '<ul>';
											foreach ($childs4 as $child4){
												$response .= '<li>';
												$response .= $this->view_block($child4);
												$childs5 = $this->direct_childs($child4);
												if (count($childs5)>0){
													$response .= '<ul>';
													foreach ($childs5 as $child5){
														$response .= '<li>';
														$response .= $this->view_block($child5);
														$childs6 = $this->direct_childs($child5);
														if (count($childs6)>0){
															$response .= '<ul>';
															foreach ($childs6 as $child6){
																$response .= '<li>';
																$response .= $this->view_block($child6);
																$childs7 = $this->direct_childs($child6);
																if (count($childs7)>0){
																	$response .= '<ul>';
																	foreach ($childs7 as $child7){
																		$response .= '<li>';
																		$response .= $this->view_block($child7);
																		$childs8 = $this->direct_childs($child7);
																		if (count($childs8)>0){
																			$response .= '<ul>';
																			foreach ($childs8 as $child8){
																				$response .= '<li>';
																				$response .= $this->view_block($child8);
																				$childs9 = $this->direct_childs($child8);
																				if (count($childs9)>0){
																					$response .= '<ul>';
																					foreach ($childs9 as $child9){
																						$response .= '<li>';
																						$response .= $this->view_block($child9);
																						$childs10 = $this->direct_childs($child9);
																						if (count($childs10)>0){
																							$response .= '<ul>';
																							foreach ($childs10 as $child10){
																								$response .= '<li>';
																								$response .= $this->view_block($child10);
																								////////////////
																								
																								////////////////
																								$response .= '</li>';
																							}
																							$response .= '</ul>';
																						}
																						$response .= '</li>';
																					}
																					$response .= '</ul>';
																				}
																				$response .= '</li>';
																			}
																			$response .= '</ul>';
																		}
																		$response .= '</li>';
																	}
																	$response .= '</ul>';
																}
																$response .= '</li>';
															}
															$response .= '</ul>';
														}
														$response .= '</li>';
													}
													$response .= '</ul>';
												}
												$response .= '</li>';
											}
											$response .= '</ul>';
										}
										$response .= '</li>';
									}
									$response .= '</ul>';
								}
								$response .= '</li>';
							}
							$response .= '</ul>';
						}
						$response .= '</li>';
					}
					$response .= '</ul>';
				}
				$response .= '</li>';
			}
			$response .= '</ul>';
			$response .= '</li>';
			$response .= '</ul>';
		} else {
			$response = '<ul id="direct_genealogy">';
			$response .= '<li>';
			$response .= $this->view_block($username);
			$response .= '<li>';
			$response .= '<ul>';
		}
		return $response;
	}
	public function completed_paid_pairs($username){
		$total_left = 0;
		$total_right = 0;
		$left_users = $this->get_leg($username, 'Left');
		if (count($left_users)>0){
			foreach ($left_users as $l_user){
				if ($this->commissions->product_purchased($l_user['username'])){
					$total_left = $total_left + 1;
				}
			}
		}
		$right_users = $this->get_leg($username, 'Right');
		if (count($right_users)>0){
			foreach ($right_users as $r_user){
				if ($this->commissions->product_purchased($r_user['username'])){
					$total_right = $total_right + 1;
				}
			}
		}
		
		$current_pairs = min($total_left, $total_right);
		return $current_pairs;
	}
	public function completed_pairs($username){
		$left_users = count($this->get_leg($username, 'Left'));
		$right_users = count($this->get_leg($username, 'Right'));
		$current_pairs = min($left_users, $right_users);
		return $current_pairs;
	}
	public function get_leg($username, $leg){
		$response = array();
		$binary = $this->get_binary($username,$leg);
		if ($binary !== false){
			$binary_to_array[] = array('username' => $binary);
			$childs = $this->getChildren($binary, 'binary_2x');
			if (count($childs)>0){
				$response = array_merge($binary_to_array,$childs);
			} else {
				$response = $binary_to_array;
			}
		}
		return $response;
	}
	public function is_position_available($binary_referral, $position){
		if ($position == 'Left' || $position == 'Right'){
			$query = $this->db->query("SELECT id FROM binary_2x WHERE binary_referral='$binary_referral' AND position='$position'")->result_array();
			if (count($query)>0){
				return false;
			} else {
				return true;
			}
		} else {
			return false;
		}
	}
	public function get_binary($username,$position){
		$query = $this->db->query("SELECT username FROM binary_2x WHERE binary_referral='$username' AND position='$position'")->result_array();
		if (count($query)>0){
			return $query[0]['username'];
		} else {
			return false;
		}
	}
	public function tree_childs($username, $table='binary_2x'){
		$childs = $this->childrens($username, $table);
		return count($childs);
	}
	public function direct_childs($username){
		$childs = array();
		$data=$this->db->query("SELECT id, username FROM binary_2x WHERE direct_referral='$username'")->result_array();
		if (count($data)>0){
			foreach($data as $d){
				$childs[] = $d['username'];
			}
		}
		return $childs;
	}
	public function binary_childs($username, $table='binary_2x'){
		$data = $this->getChildren($username, $table);
		return $data;
	}
	public function direct_childs_count($username, $table='binary_2x'){
		$data=$this->db->query("SELECT id, username FROM binary_2x WHERE direct_referral='$username'")->result_array();
		return count($data);
	}
	public function binary_childs_count($username, $table='binary_2x'){
		$data = $this->getChildren($username, $table);
		return count($data);
	}
	function getOneLevel($username, $table){
		$data=$this->db->query("SELECT id, username FROM binary_2x WHERE binary_referral='$username' ORDER by id ASC")->result_array();
		$data1=array();
		$result = array();
		if (count($data) > 0) {
			foreach ($data as $row){
				$data1['username']=$row['username'];
				$data1['id']=$row['id'];
				$result[] = $data1;
			}
		}   
		return $result;
	}
	function getSingleLevel($username){
		$query=$this->db->query("SELECT username FROM binary_2x WHERE binary_referral='$username' ORDER by id ASC");
		$username=array();
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row){
				$username[]=$row['username'];
			}
		}   
		return $username;
	}
	function getChildrenForPlacement($parent_id) {
		$tree = Array();
		if (!empty($parent_id)) {
			$tree = $this->getSingleLevel($parent_id);
			foreach ($tree as $key => $val) {
				$ids = $this->getChildrenForPlacement($val);
				$tree = array_merge($tree, $ids);
			}
		}
		return $tree;
	}
	function childrens($parent_id, $table) {
		$tree = Array();
		if (!empty($parent_id)) {
			$tree = $this->getOneLevel($parent_id, $table);
			foreach ($tree as $key => $val) {
				$ids = $this->childrens($val['username'], $table);
				$tree = array_merge($tree, $ids);
			}
		}
		
		return $tree;
	}
	public function getChildren($parent_id, $table){
	    $result = array();
	    $result1 = array();
	    $result2 = array();
	    $childrens = $this->childrens($parent_id, $table);
	    if (count($childrens)>0){
	        foreach ($childrens as $child){
	            $result[$child['username']] = $child['id'];
	        }
	    }
	    asort($result);
	    if (count($result)>0){
	        foreach ($result as $key=>$usr){
	            $result1['username'] = $key;
	            $result2[] = $result1;
	        }
	    }
	    return $result2;
	}
	public function package_purchased($username, $table){
		$data = array('1');
		if (count($data)>0){
			return true;
		} else {
			return false;
		}
	}
	function active_childs($username, $table){
		$total = 0;
		$childs = $this->getChildren($username, $table);
		if (count($childs)>0){
			foreach ($childs as $child){
				$isPurchased = $this->package_purchased($child, $table);
				if ($isPurchased == true){
					$total = $total + 1;
				}
			}
		}
		return $total;
	}
	
	public function get_binaries_in_table($table, $username, $position){
		$query = $this->db->query("SELECT username FROM $table WHERE binary_referral='$username' AND position='$position' ");
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row){
				$username = $row['username'];
			}
			return $username;
		} else {
			return false;
		}
		
	}
	public function already_existed_in_table($username, $table){
		$data = $this->general->get_tbl_field($table, '*', 'username', $username);
		if (count($data)>0){
			return true;
		} else {
			return false;
		}
	}
	
	//Conditions for multitable if any////////
	public function table_eligible($username, $table){
		$already = $this->already_existed_in_table($username, $table);
		if ($already == true){
			return false;
		} else {
			
			
			$total_active_childs = $this->getChildren($username, $table);
			if ($table == 'binary_2x'){
				if (count($total_active_childs) >= 12){
					return true;
				} else {
					return false;
				}
			}
			
		}
	
	}
	public function find_binery_refs($table, $username){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('binary_referral',$username);
		
		$user_data = $this->db->get()->result_array();
		return $user_data;
	}
	
	public function isBinaryComplete($username, $table){
		$query = $this->db->query("SELECT count(id) as binaries FROM $table WHERE binary_referral='$username'");
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row){
				$binaries = $row['binaries'];
			}
			if ($binaries == 2){
				return True;
			} else {
				return False;
			}
		} else {
			return False;
		}
	}
	public function find_binary_referral($binery_ref, $position){
		$x = 1;
		do {
			$query = $this->db->query("SELECT * FROM binary_2x WHERE binary_referral='$binery_ref' AND position='$position' ");
			if ($query->num_rows() > 0) {
				foreach ($query->result_array() as $row){
					$binery_ref = $row['username'];
				}
			}
			$x = $query->num_rows();
		} while ($x > 0);
		
		return $binery_ref;	
		
	}
	
	public function find_matrix_parent($username, $table){
		$parent = $this->binary_top_parent($username, $table);
		$binary = $this->get_spillover_space($parent, $table);
		return $binary;
	}
	public function get_spillover_space($parent, $table){
		$data = $this->general->get_tbl_field($table, '*', 'binary_referral', $parent);
		if (count($data)>0){
			if (count($data)==1){
				$arr['position'] = 'Right';
				$arr['referral'] = $parent;
			} else {
				$children = $this->getChildren($parent, $table);
				if (count($children)>0){
					
					foreach ($children as $child){
						$isCompleted = $this->isBinaryComplete($child['username'], $table);
						if ($isCompleted == false){
							$cData = $this->general->get_tbl_field($table, '*', 'binary_referral', $child['username']);
							$arr['referral'] = $child['username'];
							if (count($cData)==0){
								$arr['position'] = 'Left';
							} elseif (count($cData)==1){
								$arr['position'] = 'Right';
							}
							break;
						}
					}
				}
			}
		} else {
			$x = 0;
			$arr['position'] = 'Left';
			$arr['referral'] = $parent;
		}
		
		return $arr;
		
	}
	
	public function table_data($username, $table){
		$data = $this->general->get_tbl_field($table, '*', 'username', $username);
		return $data;
	}
	

	
	public function binary_top_parent($username, $table){
		$x = 1;
		do {
			$data = $this->db->query("SELECT binary_referral FROM $table WHERE username='$username'")->result_array();
			if (count($data)>0){
				if (empty($data[0]['binary_referral'])){
					$x = 0;
					$username = $username;
				} else {
					$username = $data[0]['binary_referral'];
				}	
			} else {
				$x = 0;
			}
		} while ($x > 0);
		return $username;
	}
	public function binary_parents($username){
		$sfx = array();
		$x = 1;
		do {
			$data = $this->db->query("SELECT binary_referral FROM binary_2x WHERE username='$username'")->result_array();
			if (count($data)>0){
				if (empty($data[0]['binary_referral'])){
					$x = 0;
				} else {
					$sfx[] = $data[0]['binary_referral'];
					$username = $data[0]['binary_referral'];
				}	
			} else {
				$x = 0;
			}
		} while ($x > 0);
		return $sfx;
	}
	public function direct_parents($username){
		$sfx = array();
		$x = 1;
		do {
			$data = $this->db->query("SELECT direct_referral FROM binary_2x WHERE username='$username'")->result_array();
			if (count($data)>0){
				if (empty($data[0]['direct_referral'])){
					$x = 0;
				} else {
					$sfx[] = $data[0]['direct_referral'];
					$username = $data[0]['direct_referral'];
				}	
			} else {
				$x = 0;
			}
		} while ($x > 0);
		return $sfx;
	}
	public function is_matrix_user($username, $table){
		$is_matrix_user = $this->already_existed_in_table($username, $table);
		if ($is_matrix_user == true){
			return true;
		} else {
			return false;
		}
	}
	public function get_binary_childs($username, $table){
		$data = $this->general->get_tbl_field_order($table, 'username', 'binary_referral', $username, 'id', 'ASC');
		return $data;
	}
	public function get_binary_childs_forced($username, $table){
		$left = array(
			'username' => '',
			'position' => 'Left',
		);
		$right = array(
			'username' => '',
			'position' => 'Right',
		);
		$data = $this->general->get_tbl_field_order($table, '*', 'binary_referral', $username, 'id', 'ASC');
		if (count($data)>0){
			foreach($data as $d){
				if ($d['position'] == 'Left'){
					$left['username'] = $d['username'];
				}
				
				if ($d['position'] == 'Right'){
					$right['username'] = $d['username'];
				}
			}
		}
		
		$response = array();
		$response['left'] = $left;
		$response['right'] = $right;
		return $response;
	}
	
	public function parents_table($binary_referral, $table, $prevoius_table){
		$sfx = array();
		$x = 1;
		do {
			$data = $this->db->query("SELECT binary_referral FROM $prevoius_table WHERE username='$binary_referral'")->result_array();
			if (count($data)>0){
				if (empty($data[0]['binary_referral'])){
					$x = 0;
				} else {
					$exists = $this->already_existed_in_table($data[0]['binary_referral'], $table);
					if ($exists == true){
						$sfx[] = $data[0]['binary_referral'];
					}
					$binary_referral = $data[0]['binary_referral'];
				}
			} else {
				$x = 0;
			}
		} while ($x > 0);
		return $sfx;
	}
	
	
	
	public function getParentsArray($binary_referral, $table){
		$sfx = array();
		$x = 1;
		do {
			$data = $this->db->query("SELECT binary_referral FROM $table WHERE username='$binary_referral'")->result_array();
			if (count($data)>0){
				if (empty($data[0]['binary_referral'])){
					$x = 0;
				} else {
					$sfx[] = $data[0]['binary_referral'];
					$binary_referral = $data[0]['binary_referral'];
				}
			} else {
				$x = 0;
			}
		} while ($x > 0);
		return $sfx;
	}
	function getChildrenArray($parent_id, $table) {
		$tree = Array();
		if (!empty($parent_id)) {
			$tree = $this->getOneLevel($parent_id, $table);
			foreach ($tree as $key => $val) {
				$ids = $this->childrens($val['username'], $table);
				$tree = array_merge($tree, $ids);
			}
		}
		$response = array();
		if (count($tree)>0){
			foreach ($tree as $user){
				$response[] = $user['username'];
			}
		}
		return $response;
	}
	public function join_eligible($username){
		$data = array(1,2,3);
		if (count($data)>0){
			return $data[0]['id'];
		} else {
			return false;
		}
	}
	
	function sponsor($username){
		$query=$this->db->query("SELECT direct_referral FROM binary_2x WHERE username='$username'");
		
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row){
				$username = $row['direct_referral'];
			}
			if (empty($username)){
				return false;
			} else {
				return $username;
			}
		} else {
			return false;
		}   
		
	}
	public function count_direct_ref($username){
		$direct_refs = 0;
		$query = $this->db->query("SELECT count(id) as total FROM binary_2x WHERE direct_referral='$username'");
			if ($query->num_rows() > 0) {
				foreach ($query->result_array() as $row){
					$direct_refs = $row['total'];
				}
				
			} 
			return $direct_refs;
	}
	public function gen_color($username=''){
		if (empty($username)){
			return 'black';
		}
		$invitees = $this->count_direct_ref($username);
		if ($invitees == 0){
			$color = 'black';
		} elseif ($invitees == 1){
			$color = 'green';
		} elseif ($invitees > 1){
			$color = 'blue';
		}
		return $color;
	}
}