// get the table element
var $table1 = document.getElementById("rhu_table"),
  // number of rows per page
  $n = 10,
  // number of rows of the table
  $rowCount1 = $table1.rows.length,
  // get the first cell's tag name (in the first row)
  $firstRow1 = $table1.rows[0].firstElementChild.tagName,
  // boolean var to check if table has a head row
  $hasHead1 = $firstRow1 === "TH",
  // an array to hold each row
  $tr1 = [],
  // loop counters, to start count from rows[1] (2nd row) if the first row has a head tag
  $i, $ii, $j1 = $hasHead1 ? 1 : 0,
  // holds the first row if it has a (<TH>) & nothing if (<TD>)
  $th1 = $hasHead1 ? $table1.rows[0].outerHTML : "";
// count the number of pages
var $pageCount1 = Math.ceil($rowCount1 / $n);
// if we had one page only, then we have nothing to do ..
if ($pageCount1 > 1) {
  // assign each row outerHTML (tag name & innerHTML) to the array
  for ($i = $j1, $ii = 0; $i < $rowCount1; $i++, $ii++) $tr1[$ii] = $table1.rows[$i].outerHTML;
  // create a div block to hold the buttons
  $table1.insertAdjacentHTML("afterend", "<div id='buttons1'></div");
  // the first sort, default page is the first one
  sort1(1);
}

// ($p) is the selected page number. it will be generated when a user clicks a button
function sort1($p) {
  /* create ($rows) a variable to hold the group of rows
  ** to be displayed on the selected page,
  ** ($s) the start point .. the first row in each page, Do The Math
  */
  var $rows1 = $th1,
    $s1 = ($n * $p) - $n;
  for ($i = $s1; $i < $s1 + $n && $i < $tr1.length; $i++) $rows1 += $tr1[$i];

  // now the table has a processed group of rows ..
  $table1.innerHTML = $rows1;
  // create the pagination buttons
  document.getElementById("buttons1").innerHTML = pageButtons1($pageCount1, $p);
  // CSS Stuff
  document.getElementById("id1" + $p).setAttribute("class", "active");
}

// ($pCount) : number of pages,($cur) : current page, the selected one ..
function pageButtons1($pCount1, $cur) {
  /* this variables will disable the "Prev" button on 1st page
     and "next" button on the last one */
  var $prevDis1 = $cur == 1 ? "disabled" : "",
    $nextDis1 = $cur == $pCount1 ? "disabled" : "",
    /* this ($buttons) will hold every single button needed
    ** it will create each button and set the onclick attribute
    ** to the "sort" function with a special ($p) number..
    */
    $buttons1 = "<input type='button' value='&lt;&lt; Prev' onclick='sort1(" + ($cur - 1) + ")' " + $prevDis1 + ">";

  // Limit the number of displayed page buttons dynamically
  var startPage = Math.max(1, $cur - 2);
  var endPage = Math.min($pCount1, startPage + 4);

  for (var $i = startPage; $i <= endPage; $i++) {
    $buttons1 += "<input type='button' id='id1" + $i + "' value='" + $i + "' onclick='sort1(" + $i + ")'>";
  }

  $buttons1 += "<input type='button' value='Next &gt;&gt;' onclick='sort1(" + ($cur + 1) + ")' " + $nextDis1 + ">";
  return $buttons1;
}