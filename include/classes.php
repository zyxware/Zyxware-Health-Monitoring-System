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
class pagination
{
	var $pagenum;
	var $pagesize=10;
	var $sqlQuery;
	var $totalNumList;

	/*function for execute the query of listing*/

	function listReportFrmDataBase()
	{
		$result = mysql_query($this->sqlQuery ." LIMIT ".($this->pagenum-1)*$this->pagesize.",".$this->pagesize)
																			or die(mysql_error());
		return($result);
	}

	/*function for list the page number*/

	function navigationBar()
	{
		$returnSeries='<table class="outerpagenumber" ><tr><td class="pgnOuterTableSkipLeft">';
		$j=1;
		$count=1;
		$countDecrement=1;
		$queryString=$_SERVER['REQUEST_URI'];
		$queryString=str_replace("&","&amp;",$queryString);
		$queryStringArray=explode("?",$queryString);

		/*The following if condition is used to get the current correct url*/

		if(count($queryStringArray)==2)
		{
			$freeQmUrlArray=explode("&amp;pagenum=",$queryString);
			if(count($freeQmUrlArray)==2)
			{
				$correctUrl=$freeQmUrlArray[0].'&amp;';
			}
			else
			{
				$rmQmPagenumArray=explode("?pagenum=",$queryString);
				if(count($rmQmPagenumArray)==2)
				{
					$correctUrl=$rmQmPagenumArray[0].'?';
				}
				else
				{
					$correctUrl=$rmQmPagenumArray[0].'&amp;';
				}
			}
		}
		else
		{
			$correctUrl=$queryStringArray[0].'?';
		}

		/* the following if condition check if the total page number is greater than 10 then add the
			 increment images*/

		if(ceil($this->totalNumList/$this->pagesize)>10)
		{
			$returnSeries.='<table><tr><td class="pgnUnSelectedPage">
											<a href="'.$correctUrl.'pagenum=1" >
												<abbr title="go to first page">
													<img src="../images/skipfirstpage.gif" alt="go to first page"/>
												</abbr>
											</a>
											</td>';
			if(($this->pagenum-1)<5)
			{
				$returnSeries.='<td class="pgnUnSelectedPage">
													<a href="'.$correctUrl.'pagenum=1">
													<abbr title="skip by 5 pages">
														<img src="../images/skip5pageleft.gif" alt="skip by 5 pages" />
													</abbr>
												</a>
											</td>';
			
			}
			else
			{
				$returnSeries.='<td class="pgnUnSelectedPage">
													<a href="'.$correctUrl.'pagenum='.($this->pagenum-5).'">
													<abbr title="skip by 5 pages">
														<img src="../images/skip5pageleft.gif" alt="skip by 5 pages" />
													</abbr>
												</a>
											</td>';
			}
			if($this->pagenum==1)
			{
				$returnSeries.='<td class="pgnUnSelectedPage">
									<a href="'.$correctUrl.'pagenum='.ceil($this->totalNumList/$this->pagesize).'">
												<abbr title="skip by 1 page">
													<img src="../images/skipleftonepage.gif" alt="skip by 1 page" />
												</abbr>
											</a>
										</td>';	
				
			}
			else
			{
				$returnSeries.='<td class="pgnUnSelectedPage">
													<a href="'.$correctUrl.'pagenum='.($this->pagenum-1).'">
													<abbr title="skip by 1 page">
														<img src="../images/skipleftonepage.gif" alt="skip by 1 page"/>
													</abbr>
												</a>
											</td>';	
			}
			
			$returnSeries.='</tr></table></td><td>';
		}

		/* the for loop list the page number */
 
		$returnSeries.='<table><tr>';	
		for($i=1;$i<=ceil($this->totalNumList/$this->pagesize);$i++)
		{
			if(ceil($this->totalNumList/$this->pagesize)<=10)
			{
				$returnSeries.=$this->pageSelectUnselect($this->pagenum,$i,$correctUrl);
			}
			else
			{
				if($this->pagenum<=5)
				{
					if($j<=10)
					{
						$returnSeries.=$this->pageSelectUnselect($this->pagenum,$i,$correctUrl);
						$j++;
					}
				}
				else if((ceil($this->totalNumList/$this->pagesize)-$this->pagenum)<5)
				{
					if((ceil($this->totalNumList/$this->pagesize)-10)<$i)
					{
						$returnSeries.=$this->pageSelectUnselect($this->pagenum,$i,$correctUrl);
					}
				}
				else
				{
					if($count<=10)
					{
						if(($this->pagenum-5)+1<=$i)
						{
							$returnSeries.=$this->pageSelectUnselect($this->pagenum,$i,$correctUrl);
							$count++;
						}
					}
				}
			}	
		}
		$returnSeries.='</tr></table>';
		/* the following if condition check if the total page number is greater than 10 then add the
			 increment images*/
		if(ceil($this->totalNumList/$this->pagesize)>10)
		{
			$returnSeries.='</td><td class="pgnOuterTableSkipRight"><table class="pagenumber"><tr>';
			if(ceil($this->totalNumList/$this->pagesize)==$this->pagenum)
			{
				$returnSeries.='<td class="pgnUnSelectedPage">
													<a href="'.$correctUrl.'pagenum=1">
													<abbr title="skip by 1 page">
														<img src="../images/skiprightonepage.gif" alt="skip by 1 page"/>
													</abbr>
												</a>
											</td>';	
				
			}
			else
			{
				$returnSeries.='<td class="pgnUnSelectedPage">
													<a href="'.$correctUrl.'pagenum='.($this->pagenum+1).'">
													<abbr title="skip by 1 page">
														<img src="../images/skiprightonepage.gif" alt="skip by 1 page"/>
													</abbr>
												</a>
											</td>';	
			}
			if((ceil($this->totalNumList/$this->pagesize)-$this->pagenum)<5)
			{
				$returnSeries.='<td class="pgnUnSelectedPage">
				<a href="'.$correctUrl.'pagenum='.ceil($this->totalNumList/$this->pagesize).'">
													<abbr title="skip by 5 pages">
														<img src="../images/skip5pageright.gif" alt="skip by 5 pages"/>
													</abbr>
												</a>
											</td>';
			
			}
			else
			{
				$returnSeries.='<td class="pgnUnSelectedPage">
												<a href="'.$correctUrl.'pagenum='.($this->pagenum+5).'">
													<abbr title="skip by 5 pages">
														<img src="../images/skip5pageright.gif" alt="skip by 5 pages"/>
													</abbr>
												</a>
											</td>';
			}
			$returnSeries.='<td class="pgnUnSelectedPage">
				<a href="'.$correctUrl.'pagenum='.ceil($this->totalNumList/$this->pagesize).'">
													<abbr title="go to last page">
														<img src="../images/skiplastpage.gif" alt="go to last page"/>
													</abbr>
												</a>
											</td>';
			$returnSeries.='</tr></table>';	
		}
		$returnSeries.='</td></tr></table>';
		return($returnSeries);
	}
	
	/*function for dispaly the information of the listing*/
	
	function displayListInformation()
	{
		$displayReturn='<table class="displyLstInfo"><tr><td>Page '.$this->pagenum.'/'
											.ceil($this->totalNumList/$this->pagesize).' showing records '
											.((($this->pagenum-1)*$this->pagesize)+1).' - ';
		if(ceil($this->totalNumList/$this->pagesize)==$this->pagenum)
		{
			$displayReturn.=$this->totalNumList;
		}
		else
		{
			$displayReturn.=(($this->pagenum-1)*$this->pagesize)+10;
		}
		$displayReturn.=' of '.$this->totalNumList.'</td></tr></table>';
		return($displayReturn);
		
	}

	/* function for page number is select or unselect */
	
	function pageSelectUnselect($currentPagenum,$count,$correctUrl)
	{
		if($currentPagenum==$count)
		{
			$returnString='<td class="pgnSelectedPage">'.$count.'</td>';
		}
		else
		{
			$returnString='<td class="pgnUnSelectedPage">
										<a class="linkstyle" href="'.$correctUrl.'pagenum='.$count.'">'.$count.'</a>
											</td>';
		}
		return($returnString);
	}
}
