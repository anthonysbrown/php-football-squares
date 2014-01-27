<?php

class football_squares{
	
		public $rows = 10;
		public $cols = 10;
		public $data = 'data.txt';
		public $password = 'password';
		public $team_one = 'Team One';
		public $team_two = 'Team Two';
		public $price = '5.00';
		function __construct(){
						
			
		//error_reporting(E_ALL);
		//ini_set('display_errors', '1');
		session_start();
		

			
			if($_GET['logout'] == 1){
				$exp = time() + (86400 * 30);
			setcookie('auth', '', -$exp);
			header("Location: index.php");	
			}
		}
		
	
		function write($id,$value){
			
			$data = $this->data();
			
			$data[$id] = $value;
			
			
			
			$write = serialize($data);
			file_put_contents($this->data, $write);
			
			
		}
		function data(){
		 $file = $this->data;
    		
					
		if (file_exists( $file)) {
			$data = file_get_contents( $file);
		} else {
			file_put_contents($file, serialize(array()));
			$data = file_get_contents( $file);
		}
			
		
  
 		 $array = unserialize($data);
		 
		 return $array;
			
			
		}
		

		
		function form($id,$entry = ''){
			
			if($entry != ''){
				$value = $entry ;
			}else{
				$value = $_SESSION['name'] ;
			}
			
			$h .='<div style="display:none"><div class="register_square_'.$id.'"><form action="index.php" method="post">
			<input type="hidden" name="id" value="'.$id.'">
				  Name: <input type="text" name="name" value="'.$value.'" style="width:200px"> <input type="submit" name="save" value="Save it!">
				  </form></div></div>';
				  
				  return $h;
		}
		function build(){
				
				
				if($_POST['save'] != ''){
					
					$this->write($_POST['id'],$_POST['name']);
					$_SESSION['name'] = $_POST['name'];
				}
				
				
				$columns = 100 /  $this->cols;
				$data = $this->data();
				
				
				$h .='<style type="text/css">
				.square_col{width:'.$columns.'%}
					  </style>
					  <div id="team_one">'.$this->team_one.'</div>
						<div id="team_two">'.$this->team_two.'</div>
					  
					  <div id="squares_container">';
						$abs = 0;
					
					
					for($i=0; $i< $this->rows; $i++){
						if($i != 0){
						$abs += $this->cols;
						}
						$cols =0;
						$h .= '<div class="square_row">';
							for($c=0; $c< $this->cols; $c++){
								$cols++;
								$num = $cols + $abs;
								
								if($data[$num] == ''){
								$link = '<a href="javascript:squares_popup(\'.register_square_'.$num.'\')" >Register <br>#'.$num.'</a>';	
								}else{
									
									if($this->auth() == true){
									 $picked = 'javascript:squares_popup(\'.register_square_'.$num.'\')';
									 
									 if($data[$num] != ''){
										 $entry  = $data[$num];
									 }
									}else{
									 $picked = '#';	
										$entry  = '';
									}
									
									
								$link = '<a href="'.$picked.'" class="chosen">'.$data[$num].'</a>';	
								}
								
								$h .= '<div class="square_col">
								<div class="square_col_inside">
								'.$link .'
								'.$this->form($num,$entry).'
								</div> 
								</div>';
							}
						
						$h .='<div style="clear:both"></div></div>';
						
					}
					$h .= '</div>';
					
					$h .= $this->admin();
					$h .= $this->stat_data();
				return $h;			
		}
		
		
				function stat_data(){
			
			$data = $this->data();
			$total = count($data);
			$totals = array_count_values($data);
			$left = ($this->rows * $this->cols) - $total;
			$total_squares .='<ul>';
			foreach($totals as $name => $times){
					
						$total_price = $times * $this->price;
						$total_squares .= '<li>'.$name.' has  '.$times.' squares $'.$total_price.'</li>';
				
			}
			$total_squares .='</ul>';
			
			$h .='<div class="noPrint">
			  <script>
  $(function() {
    $( "#progressbar" ).progressbar({
      value: '.$total .'
    });
  });
  </script>

			
			<h2>Stats</h2>
			<div id="progressbar"><div class="progress-label">'.$total .'% Complete, only '.$left.' squares left. </div></div>	
			'.$total_squares.'	
				
				</div>
			';
			
			return $h;
		}
		
		function auth(){
		
				if($_COOKIE['auth'] != '' && $_COOKIE['auth'] == md5($this->password)){
					
				return true;
				
				}else{
					
				return false;	
				}
			
		}
		function admin(){
				
		if($_POST['password'] != ''){
			
				if($_POST['password']  == $this->password){
				
				$exp = time() + (86400 * 30);
				setcookie('auth', md5($_POST['password']), $exp);
				header("Location: index.php");
				}else{
				$h .= 'Inccorect Login';
				}
				
			}
			
		
		
			$h .= '<div class="squares_login noPrint">';
			
			if($this->auth() == false){
					$h .='<a href="javascript:squares_popup(\'.admin_login\')" class="button">Login</a>';
			}else{
				$h .='<a href="?logout=1" class="button">Logout</a>';
			}
					
					$h .='<div style="display:none"><div class="admin_login"><form action="index.php" method="post">
			
				  Password: <input type="text" name="password"  style="width:200px"> <input  type="submit" name="login" value="Login">
				  </form></div></div>
					
					</div>';
					
			
			
			return $h;
			
		}
}
?>