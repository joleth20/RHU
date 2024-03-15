// get the table element
var $table2 = document.getElementById("rhu_table1"),
  // number of rows per page
  $n = 10,
  // number of rows of the table
  $rowCount2 = $table2.rows.length,
  // get the first cell's tag name (in the first row)
  $firstRow2 = $table2.rows[0].firstElementChild.tagName,
  // boolean var to check if table has a head row
  $hasHead2 = $firstRow2 === "TH",
  // an array to hold each row
  $tr2 = [],
  // loop counters, to start count from rows[1] (2nd row) if the first row has a head tag
  $i, $ii, $j2 = $hasHead2 ? 1 : 0,
  // holds the first row if it has a (<TH>) & nothing if (<TD>)
  $th2 = $hasHead2 ? $table2.rows[0].outerHTML : "";
// count the number of pages
var $pageCount2 = Math.ceil($rowCount2 / $n);
// if we had one page only, then we have nothing to do ..
if ($pageCount2 > 1) {
  // assign each row outerHTML (tag name & innerHTML) to the array
  for ($i = $j2, $ii = 0; $i < $rowCount2; $i++, $ii++) $tr2[$ii] = $table2.rows[$i].outerHTML;
  // create a div block to hold the buttons
  $table2.insertAdjacentHTML("afterend", "<div id='buttons2'></div");
  // the first sort, default page is the first one
  sort2(1);
}

// ($p) is the selected page number. it will be generated when a user clicks a button
function sort2($p) {
  /* create ($rows) a variable to hold the group of rows
  ** to be displayed on the selected page,
  ** ($s) the start point .. the first row in each page, Do The Math
  */
  var $rows2 = $th2,
    $s2 = ($n * $p) - $n;
  for ($i = $s2; $i < $s2 + $n && $i < $tr2.length; $i++) $rows2 += $tr2[$i];

  // now the table has a processed group of rows ..
  $table2.innerHTML = $rows2;
  // create the pagination buttons
  document.getElementById("buttons2").innerHTML = pageButtons2($pageCount2, $p);
  // CSS Stuff
  document.getElementById("id2" + $p).setAttribute("class", "active");
}

// ($pCount) : number of pages,($cur) : current page, the selected one ..
function pageButtons2($pCount2, $cur) {
  /* this variables will disable the "Prev" button on 1st page
     and "next" button on the last one */
  var $prevDis2 = $cur == 1 ? "disabled" : "",
    $nextDis2 = $cur == $pCount2 ? "disabled" : "",
    /* this ($buttons) will hold every single button needed
    ** it will create each button and set the onclick attribute
    ** to the "sort" function with a special ($p) number..
    */
    $buttons2 = "<input type='button' value='&lt;&lt; Prev' onclick='sort2(" + ($cur - 1) + ")' " + $prevDis2 + ">";

  // Limit the number of displayed page buttons dynamically
  var startPage2 = Math.max(1, $cur - 2);
  var endPage2 = Math.min($pCount2, startPage2 + 4);

  for (var $i = startPage2; $i <= endPage2; $i++) {
    $buttons2 += "<input type='button' id='id2" + $i + "' value='" + $i + "' onclick='sort2(" + $i + ")'>";
  }

  $buttons2 += "<input type='button' value='Next &gt;&gt;' onclick='sort2(" + ($cur + 1) + ")' " + $nextDis2 + ">";
  return $buttons2;
}