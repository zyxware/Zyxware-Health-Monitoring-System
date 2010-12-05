<?php
/*
  This file is part of Zyxware Health Monitoring System -
  A Web Based application to track Diseases

  Copyright (C) 2007 Zyxware Technologies
    info@zyxware.com

  For more information or to find the latest release, visit our
  website at http://www.zyxware.com/

  This program is free software; you can redistribute it and/or
  modify it under the terms of the GNU General Public License as
  published by the Free Software Foundation; either version 3 of the
  License, or (at your option) any later version.

  This program is distributed in the hope that it will be useful, but
  WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
  General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
  02111-1307, USA.

  The GNU General Public License is contained in the file COPYING.
*/
session_start();
	include("../include/projectlib.inc.php");
	includeHeaders();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
	<html>
		<head>
			<script type="text/javascript">
				<!--
					//-->
			</script>
			<?php
				includeJs();
				includeCss();
			?>
		<title>
			More Info..
		</title>
		</head>
<?php
		echo '<body id="bdySummary" style="width:'.$_GET['rightContent'].'px">';

				showFormContent();
?>
		</body>
	</html>	
<?php
	function showFormContent()
	{
		echo'<table  class="specialTbl">	
				<tr>
					<td class="tdSpecial">';

						displayMenuBar();
?>
					</td>
				</tr>
				<tr>
					<td>
						<table>
							<tr>
								<td class="tdAlign">
									<h4>
										About Kerala Health Monitor
									</h4>
										<p>This is a public service application created for free by <a href="http://www.zyxware.com" target="_blank">Zyxware Technologies</a> for Government of Kerala. The application helps to identify and track in realtime the occurence and spread of diseases, specifically the potent and the communicable ones, over the web. It uses an easy to use web based interface integrated with the display of the collected information on a navigable map. Using this software public authorities can identify trends and patterns in the spread of diseases and take timely remedial action. Additionally this system would make reporting of diseases by the hospitals to the District Medical officials much more easier, efficent and environment friendly(paper-less).
									</p> 
								</td>
							</tr>
							<tr>
								<td class="tdAlign">
									<h5>
										Employees of Hospitals
									</h5>
									<p>
										If you are an employee of the hospital and your work involves reporting of diseases to the Government Health Officials you can click on the following link to create a userid for yourself. Once your request is verified and processed you will get an approved userid which you can use to access the system.
									</p>
									
										<a href="hospitalregform.php" >
											Register here
										</a>
								</td>
							</tr>
							<tr>
								<td class="tdAlign">
									<h5>
										Public Health Officials
									</h5>
									<p>
										If you are a public health official working under Government of Kerala and you are involved with collection of disease reports from hospitals you may please click on the following link to create a userid for yourself. Once your request is verified and processed you will get an approved userid which you can use to access the system
									</p>
									
									<a href="gmoregform.php" >
										Register here
									</a>
								</td>
							</tr>
							<tr>
								<td class="tdAlign">
									<h5>
										Government Data Entry Operators
									</h5>
									<p>
										If you are a data entry operator working with the Kerala Health Monitor Project you can click on the following link to create a userid for yourself. Once your request is verified and processed you will get an approved userid which you can use to access the system.
									</p>
										<a href="deoregform.php" >
											Register here
										</a>
										<br><br>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>

<?php
	}
?>
