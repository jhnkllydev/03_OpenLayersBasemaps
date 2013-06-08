<?php
/* configuration
 */
// a web-accessible temporary directory
// Specify both the path name and the URL where those files can be browsed
// Don't worry if your content is private: randomly-generated filenames so folks can't predict and grab past PDFs
$TEMP_DIR = "/maps/images.tmp/";
$TEMP_URL = "http://websites.greeninfo.org/images.tmp";

error_log('morongo');

// the path and flags to the WK utilities
//$WKPDF = "/usr/local/bin/wkhtmltopdf --quiet --disable-smart-shrinking --image-quality 100 --page-size letter";
//$WKIMG = "/usr/local/bin/wkhtmltoimage --javascript-delay 5000 --disable-smart-width";

//reverting to 0.10.0 rc2
$WKPDF = "./wkhtmltopdf-amd64 --quiet --disable-smart-shrinking --image-quality 100 --page-size letter --margin-top '5mm'  --margin-bottom '5mm' --enable-external-links ";
$WKIMG = "/usr/local/bin/wkhtmltoimage-0.10.0 --javascript-delay 3000 --disable-smart-width";


// the URL to the CSS files, font files, JavaScript files, and so on
// yes, WK supports loading content from remote server just like a real browser!
$BASEURL = "http://websites.greeninfo.org/morongo/mbcv/live/print";
$APPURL = "http://websites.greeninfo.org/morongo/mbcv/dev3";

// the size of the map image; can be done in CSS but read below about using
// a fixed size and generating the image separately
//$MAP_WIDTH  = 768;
$MAP_WIDTH  = 600;
//$MAP_HEIGHT = 874;
$MAP_HEIGHT = 600;

////////////////////////////////////////////////////////
////////////////////////////////////////////////////////

// sanitize a few things
/* $_POST['lat']  = (float) $_POST['lat'];
$_POST['lon']  = (float) $_POST['lon'];
$_POST['z'] = (integer) $_POST['z']; */

//$ARGS = $_POST['lys']; 
$printArgs = $_POST['printArgs']; 
$allVecRes = $_POST['stats']; 
$LYS = $_POST['lys'];

error_log($_POST['printArgs']);
//error_log($_POST['stats']);

// define filenames
$random  = md5(mt_rand());
$htmfile0 = sprintf("%s/%s.html", $TEMP_DIR, "morongo_".$random );
$htmfile = sprintf("%s/%s.htm", $TEMP_DIR, "morongo_".$random );
$pngfile = sprintf("%s/%s.png", $TEMP_DIR, "morongo_".$random );
$pdffile = sprintf("%s/%s.pdf", $TEMP_DIR, "morongo_".$random );
$pdfurl  = sprintf("%s/%s.pdf", $TEMP_URL, "morongo_".$random );
$pngurl  = sprintf("%s/%s.png", $TEMP_URL, "morongo_".$random );

/*
 * STRATEGY: wkhtmltopdf has some issues with image quality, which
 * are best solved by generating images separately and then loading them at their known, fixed size.
 * Thus, we make two calls here: one to render nothing but an OpenLayers map as a static PNG file,
 * then one to generate the HTML layout using static images (including that brand-new static image).
 */
/*
 * DEBUGGING TECHNIQUE: Since the template is HTML, JavaScript, and CSS meant for a browser,
 * you can simply print the HTML and exit, and view the template in your browser. It won't be
 * identical even if you're using a WebKit browser (Chrome or Safari) but it's invaluable in
 * debugging JavaScript and CSS issues.
 */

// load the IMG template, which defines a Google Maps screenshot
// save it to disk, have WK crunch it
require 'template_map.php';
//print $html;exit;
file_put_contents($htmfile0,$html);
shell_exec("$WKIMG --width $MAP_WIDTH --height $MAP_HEIGHT $htmfile0 $pngfile");
//print $pngurl;exit;

// load the HTML template, which defines $html and which contains that $pngfile we just created a moment ago
// save it to disk, have WK crunch it
require 'template2_html.php';
//print $html;exit;
file_put_contents($htmfile,$html);
shell_exec("$WKPDF $htmfile $pdffile");

// spit out the PDF to the browser, triggering a download
header('Content-type: application/pdf');
header('Content-disposition: attachment; filename="Map.pdf"');
//readfile($pdfurl);
printf($pdfurl);
//printf("%s/%s/%s", $CONFIG['TEMP_URL'], $random, basename($outfilename) );

