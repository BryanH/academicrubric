<?php

$GLOBALS['rst'] = 0;

$GLOBALS['output'] = '';

if ( isset( $_GET['keyword'] ) && !empty( $_GET['keyword'] ) ) {

	$_GET['keyword'] = htmlspecialchars( $_GET['keyword'] );

}

if ( isset( $_GET['search'] ) && !empty( $_GET['search'] ) ) {

	$_GET['search'] = htmlspecialchars( $_GET['search'] );

}

  class pagination {
    var $page = 1; // Current Page
    var $perPage = 10; // Items on each page, defaulted to 10
    var $showFirstAndLast = true; // if you would like the first and last page options.

    function generate($array, $perPage = 10) {
      // Assign the items per page variable
      if (!empty($perPage)) {
        $this->perPage = $perPage;
      }

      // Assign the page variable
      if (!empty($_GET['page'])) {
        $this->page = $_GET['page']; // using the get method
      } else {
        $this->page = 1; // if we don't have a page number then assume we are on the first page
      }

      // Take the length of the array
      $this->length = count($array);

      // Get the number of pages
      $this->pages = ceil($this->length / $this->perPage);

      // Calculate the starting point
      $this->start  = ceil(($this->page - 1) * $this->perPage);

      // Return the part of the array we have requested
      return array_slice($array, $this->start, $this->perPage);
    }

    function links() {
      // Initiate the links array
      $plinks = array();
      $links = array();
      $slinks = array();

      // Concatenate the get variables to add to the page numbering string
      if (count($_GET)) {
        $queryURL = '';
        foreach ($_GET as $key => $value) {
          if ($key != 'page') {
            $queryURL .= '&'.$key.'='.$value;
          }
          if ($key == 'loc') {
          	foreach ($_GET['loc'] as $kx => $value) {
          		         	$queryURL .= '&loc[]='.$value;
          	 }
          }
        }
      }


      // If we have more then one pages
      if (($this->pages) > 1)
      {
        // Assign the 'previous page' link into the array if we are not on the first page
        if ($this->page != 1) {
          if ($this->showFirstAndLast) {
            $plinks[] = '<li class="prev"> <a href="?page=1'.$queryURL.'">&laquo;&laquo; First </a> </li>';
          }
          $plinks[] = '<li class="prev"> <a href="?page='.($this->page - 1).$queryURL.'">&laquo; Prev</a></li> ';
        }

        // Assign all the page numbers & links to the array
        for ($j = 1; $j < ($this->pages + 1); $j++) {
          if ($this->page == $j) {
            $links[] = ' <li class="current"><a>'.$j.'</a></li> '; // If we are on the same page as the current item
          } else {
            $links[] = ' <li class="rgl"><a href="?page='.$j.$queryURL.'">'.$j.'</a></li> '; // add the link to the array
          }
        }

        // Assign the 'next page' if we are not on the last page
        if ($this->page < $this->pages) {
          $slinks[] = '<li class="next"> <a href="?page='.($this->page + 1).$queryURL.'"> Next &raquo; </a></li> ';
          if ($this->showFirstAndLast) {
            $slinks[] = '<li class="next"> <a href="?page='.($this->pages).$queryURL.'"> Last &raquo;&raquo; </a></li> ';
          }
        }

        // Push the array into a string using any some glue
        return implode(' ', $plinks).implode($this->implodeBy, $links).implode(' ', $slinks);
      }
      return;
    }
  }


function trim_value(&$value)
{
    $value = trim($value);
}

function xml2array($xml)
	{
    	$arr = array();

    foreach ($xml as $element)
    {
        $tag = $element->getName();
        $e = get_object_vars($element);
        if (!empty($e))
        {
            $arr[$tag] = $element instanceof SimpleXMLElement ? xml2array($element) : $e;
        }
        else
        {
            $arr[$tag] = trim($element);
        }
    }

    return $arr;
}

$i=0;
$kxk='';
$resultcount=0;
$output = array();
$keyword = array();
$rbx = array();
$cnbr = array();
$loc = array();
$search = array();
$semester = array();
$qualification = array();
$tmp=$_GET['keyword'];
$keyword = explode(" ",$tmp);
$keyword=array_map('strtolower', $keyword);
array_push($qualification,$_GET['qualification']);
array_push($rbx, $_GET['rbx']);

$rbx=array_map('strtolower', $rbx);
array_push($cnbr, $_GET['cnbr']);
$loc = $_GET['loc'];
if( !empty($loc)){
$loc=array_map('strtolower', $_GET['loc']);
$loc = array_filter($loc);
}
$crd = $_GET['credit'];
if( !empty($crd )){
$crd =array_map('strtolower', $_GET['credit']);
$crd  = array_filter($crd);
}
array_push($search, $_GET['search']);
array_push($semester, $_GET['semester']);


if(empty($_GET['search'])){
$_GET['search']='program';
}

/*
var_dump( $keyword);
echo "<br/>";
var_dump( $rbx);
echo "<br/>";
var_dump( $cnbr);
echo "<br/>";
var_dump( $loc);
echo "<br/>";
var_dump( $semester);
echo "<br/>";
var_dump( $search);
echo "<br/>";
*/

            if( !empty($search) && in_array('course',$search) )
            {

            if( ! $xmlc = simplexml_load_file("index_ok_crs.xml") )
    		{
         			echo "Unable to load XML file";
    		}
    		else
    		{

						foreach( $xmlc->item as $key=>$element )
        				{

                                                   $showitem=true;
        					   $kxs =(string)$element ->title[0];
							$kx = explode(" ", $kxs);
							$kx=array_map('strtolower', $kx);
							$xnbr = (string)$element ->cnbr[0];
							$nbr = explode(" ", $xnbr);
							$crs = (string)$element ->rbx[0];
							$crx = explode(" ", $crs);
							$crx = array_map('strtolower', $crx);
							$detail= (string)$element ->detail[0];
							$op = $element->loc->children();
							$local=array();
							foreach ($op as $entry) {
    							array_push($local,$entry);
    						        }
							array_walk($local, 'trim_value');
							$local=array_map('strtolower',$local);
							$ccd = $element->cred->children();
							$flag=false;
							if (empty($ccd)){
								 $flag=true;
							}
							$cred=array();
							foreach ($ccd as $entry) {
    							array_push($cred,$entry);
    						}
							array_walk($cred, 'trim_value');
							$cred=array_map('strtolower',$cred);


							if( isset($_GET['rbx']) && $showitem)
							{

								$showitem=false;
								$rescop = array_intersect($rbx, $crx);
								foreach( $rescop as $xy => $value )
								{
    								$showitem=true;
								}
							}
							if( isset($_GET['cnbr']) && $showitem)
							{

								$showitem=false;
								$rescop = array_intersect($nbr, $cnbr);
								foreach( $rescop as $xy => $value )
								{
    								$showitem=true;
								}
							}

							if( !empty($loc) && $showitem)
							{

								$showitem=false;
								$rescop = array_intersect($loc, $local);
								foreach( $rescop as $xy => $value )
								{
    								$showitem=true;
								}
							}
                                                             if( !empty($crd) && $showitem)
							{

								$showitem=false;
								$rescop = array_intersect($crd, $cred);
								foreach( $rescop as $xy => $value )
								{
    								$showitem=true;
								}
								if (($flag)&&(in_array('non-credit',$_GET['credit'])))
								{
									$showitem=true;

								}

							}
							if(isset($_GET['keyword']) && $showitem && (!empty($_GET['keyword'])) )
							{
								$showitem=false;
								$rescop = array_intersect($keyword, $kx);
								foreach( $rescop as $xy => $value )
								{
    								$showitem=true;
								}

							}


							if($showitem)
							{

								array_push($output, $detail);
                                sort($output);
								$resultcount++;
                                $GLOBALS['rst']=$resultcount;
							}
						}
}


			}

else
            {

            if( ! $xmld = simplexml_load_file("index_deg.xml") )
    		{
         			echo "Unable to load XML file";
    		}
    		else
    		{

						foreach( $xmld->item as $key=>$element )
        				{

        				$detail= (string)$element ->detail[0];
                        $showitem=true;
        				$kxs =(string)$element ->title[0];
                        $UID =(string)$element ->uid[0];
                        $cld =(string)$element ->keys[0];
                        $cloud = explode(",", $cld);
						$cloud=array_map('strtolower', $cloud);
						$kx = explode(" ", $kxs);
						$kx=array_map('strtolower', $kx);
						$tagcloud = array_merge($kx, $cloud);
                        $deg =(string)$element ->degree[0];
						$degree = explode(" ", $deg);
						$degree=array_map('strtolower', $degree);
                        if( isset($_GET['keyword']) && $showitem  && (!empty($_GET['keyword'])))
						{
							$showitem=false;
							$rescop = array_intersect($keyword, $tagcloud);
							foreach( $rescop as $xy => $value )
							{
    								$showitem=true;
							}
							}
                                if( isset($_GET['UID']) && $showitem)
						        {
							$showitem=false;
							if ($UID == ($_GET['UID']))
							{
    								$showitem=true;
							}
							}
                                if(isset($_GET['qualification']) && $showitem)
						        {
							$showitem=false;
							$rescop = array_intersect($qualification,$degree);
							foreach( $rescop as $xy => $value )
							{
    								$showitem=true;
							}
							}
							if($showitem)
							{

								array_push($output, $detail);
                                sort($output);
								$resultcount++;
                                $GLOBALS['rst']=$resultcount;
							}
						}
			}
		}
?>





<div class="wrapper">
<?php
if (count($_GET))  {
        $queryURL = '/finder/index.php';
        $queryURL .= '?search=course';
        foreach ($_GET as $key => $value) {
          if ($key != 'page'&&$key != 'search'&&$key != 'keyword' ) {
            $queryURL .= '&'.$key.'='.$value;
          }
          if ($key == 'loc') {
          	foreach ($_GET['loc'] as $kx => $value)
          	{
          		         	$queryURL .= '&loc[]='.$value;
          		         }
          }
           if ($key == 'keyword') {
                $ct=count($_GET['keyword'])+1;
          	foreach ($keyword as $kx => $value)
                {

          	 $kxk.=$value;
                 if($ct!=$kx){$kxk.='%20';}

          	}
		$queryURL .= '&keyword='.$kxk;
          }


}}
$ot='';
$kxk='';
if($_GET['search']=='course')
{$ot = " class='active'";}
echo "<ul class='toggle'><li".$ot."><a href=".$queryURL.">Courses</a></li>";
if (count($_GET)) {
        $queryURL = '/finder/index.php';
        $queryURL .= '?search=program';
        foreach ($_GET as $key => $value) {
          if ($key != 'page'&&$key != 'search'&&$key != 'keyword' ) {
            $queryURL .= '&'.$key.'='.$value;
          }
          if ($key == 'loc') {
          	foreach ($_GET['loc'] as $kx => $value)
          	{
          		         	$queryURL .= '&loc[]='.$value;
          		         }
          }
          if ($key == 'keyword') {
          	$ct=count($_GET['keyword'])+1;
          	foreach ($keyword as $kx => $value)
                {

          	 $kxk.=$value;
                 if($ct!=$kx){$kxk.='%20';}

          	}
		$queryURL .= '&keyword='.$kxk;

          }

        }
}
$ot='';
if($_GET['search']=='program')
{$ot = " class='active'";}
echo "<li".$ot."><a href=".$queryURL.">Degrees</a></li></ul>";
?>
				<div class="right">
					<form action="/finder/index.php" method="get" class="find-course" role="search">

						<div class="form-wrapper">
							<input type="text" id="program-search2" name="keyword" <?php if (count($_GET)) {foreach ($_GET as $key => $value) {
          if ($key =='keyword') { $out=$value;}}if($out){echo "value='".$out."'";} else{echo "placeholder='Search Term'";}} ?>"><input type="hidden" name="search" value="<?php echo ($_GET['search']); ?>"><label for="program-search2">Search</label>
							<input type="submit" value="Go">
						</div>
					</form>
					<ul class="cta">
						<li><a href="/district/students/get-help/">Get Help >></a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="content-wrapper has-tabs">
			<div id="main-content" class="wrapper wide">
				<div class="left-col">
					<form method="get" action="index.php"" class="filter" role="search">
<input type="hidden" name="search" value="<?php echo ($_GET['search']); ?>"><input type="hidden" name="keyword" value="<?php echo ($_GET['keyword']); ?>">
						<a href="#" class="back-results">Back to results ?</a>
						<h5>Narrow your choices <a href="#" title="Hide filters">x</a></h5>
						<div class="filter-group">
							<div class="submit">
								<input type="submit" value="Update >>">

							</div>
							<!--<div class="types">
								<input type="checkbox" name="credit[]" value="credit" id="credit" <?php if(in_array('credit',$_GET['credit'])) echo 'checked'; ?>> <label for="credit">Credit</label><br>
<input type="checkbox" name="credit[]" value="non-credit" id="non-credit" <?php if(in_array('non-credit',$_GET['credit'])) echo 'checked'; ?>> <label for="non-credit">Non-credit</label><br>
							</div>-->
							<fieldset <?php if($_GET['search']=='course')
{echo "style='display:none;'";}   ?>>
								<legend>Type</legend>
								<div class="choices">
									<input id="degree" type="radio" value="associate" name="qualification" <?php if(in_array('associate',$qualification)){ echo 'checked';} ?> > <label for="degree">Degree</label><br>
									<input type="radio" id="certificate"  value="certificate" name="qualification" <?php if(in_array('certificate',$qualification)) { echo 'checked';} ?> > <label for="certificate">Certificate</label><br>

								</div>
							</fieldset>
							<fieldset <?php if($_GET['search']=='program')
{echo "style='display:none;'";}   ?>>
								<legend>Location</legend>
								<div class="choices">
<input type="checkbox" id="central" value="CE" name="loc[]" <?php if(in_array('CE',$_GET['loc'])) echo 'checked'; ?> > <label for="central">Central College</label><br><input type="checkbox" id="coleman" value="HS" name="loc[]" <?php if(in_array('HS',$_GET['loc'])) echo 'checked'; ?>> <label for="coleman">Coleman College</label><br><input type="checkbox" id="northeast" value="NE" name="loc[]" <?php if(in_array('NE',$loc)) echo 'checked'; ?>> <label for="northeast">Northeast College</label><br>

<input type="checkbox" id="northwest" value="NW" name="loc[]" <?php if(in_array('NW',$_GET['loc'])) echo 'checked'; ?>> <label for="northwest">Northwest College</label><br>

<input type="checkbox" id="southeast" value="SE" name="loc[]" <?php if(in_array('SE',$_GET['loc'])) echo 'checked'; ?>> <label for="southeast">Southeast College</label><br>
<input type="checkbox" id="soutwest" value="SW" name="loc[]" <?php if(in_array('SW',$_GET['loc'])) echo 'checked'; ?>> <label for="soutwest">Southwest College</label><br>
<input type="checkbox" id="online" value="DE" name="loc[]" <?php if(in_array('DE',$_GET['loc'])) echo 'checked'; ?>> <label for="online">Online</label><br>
								</div>
							</fieldset>
							<fieldset style='display:none;'>
								<legend>Time</legend>
								<div class="choices">
									<input type="checkbox" id="day"> <label for="day">Day</label><br>
									<input type="checkbox" id="evening"> <label for="evening">Evening</label>
								</div>
							</fieldset>
							<div class="submit">
								<input type="submit" value="Update >>">
							</div>
						</div>
					</form>

				</div><!-- /left-col -->
				<div class="right-col">
					<article role="main">
						<section class="course-listings">
							<div class="search-results">
								<p class="showing">Showing <strong><?php echo $GLOBALS['rst']." "; ?></strong> results
<?php
if (count($_GET['keyword'])) {
echo "for <strong>Search Term</strong>: ".$_GET['keyword'];
}
 ?></p>
								<ul class="terms">

								</ul>

							</div>
							<div class="slide-group">
								<!-- <div class="slide-toggle">
									<a href="#" class="narrow"> Narrow Your Choices</a>
									<a href="#" class="prev">Prev</a>
									<a href="#" class="next">Next</a>
								</div>-->
								<t4 type="navigation" id="294"/><t4 type="navigation" id="296"/>
<?php

						$pagination = new pagination;



        // If we have an array with items
        if (count($output)) {
          // Parse through the pagination class
          $productPages = $pagination->generate($output, 10);
          // If we have items
          if (count($productPages) != 0) {
            // Create the page numbers
            echo $pageNumbers = '<div class="pagination"><ul>'.$pagination->links().'</ul></div>';
            // Loop through all the items in the array
            foreach ($productPages as $productArray) {
              // Show the information about the item
              echo $productArray ;
            }
            // print out the page numbers beneath the results
            echo $pageNumbers;
          }
        }





?>