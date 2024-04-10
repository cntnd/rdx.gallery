<?php
$be = '';
$art = 'REX_VALUE[1]';
$sort = 'REX_VALUE[2]';
$hasComments = (bool)'REX_VALUE[3]';
$comments = rex_var::toArray('REX_VALUE[4]');
// Bilderteppich
$carpet_container = 'REX_VALUE[5]';
$carpet_container = !empty($carpet_container) ? $carpet_container : "unigrid--row";
$carpet_container = ($art == "carpet") ? $carpet_container : "";
$carpet_item = 'REX_VALUE[6]';
$carpet_item = !empty($carpet_item) ? $carpet_item : "brick brick-6";
// Galerie mit Vorschaubild
$thumb_image = 'REX_VALUE[7]';

$fe = '<div class="' . $carpet_container . ' cntnd_gallery" style="width: 100% !important;">';

// Medialist
if ("REX_MEDIALIST[1]" != '') {
    if ($art == "thumb") {
        $fe .= '<span id="gallery605"><img src="' . rex_url::media($thumb_image) . '" class="cntnd_img cntnd_gallery_link" /></span>';

        $fe .= '<script type="text/javascript">' . "\n";
        $fe .= '<!--' . "\n";
        $fe .= '$(document).ready(function() {' . "\n";
        $fe .= '  $("#gallery605").click(function() {' . "\n";
        $fe .= '    $.fancybox.open([' . "\n";
    }

    $imagelist = explode(',', "REX_MEDIALIST[1]");
    if ($sort == "asc") {
        asort($imagelist);
    } else if ($sort == "desc") {
        arsort($imagelist);
    }

    foreach ($imagelist as $file) {
        $media = rex_media::get($file);
        $file_url = rex_url::media($file);
        if ($media) {
            $mediatitle = $media->getValue('title');
            $mediadesc = str_replace(array("\r\n", "\n", "\r"), ' ', $media->getValue('med_description'));
            $mediawidth = $media->getValue('width');
            $mediaheight = $media->getValue('height');
            if ($hasComments) {
                $mediadesc = $comments[$file];
            }

            if ($art == "thumb") {
                $thumb_comment="";
                if ($hasComments && !empty($mediadesc)) {
                    $thumb_comment = ", caption: '$mediadesc'";
                }
                $fe .= "{ src : '$file_url' $thumb_comment},";
            } else if ($art == "carpet") {
                $fe .= '<div class="' . $carpet_item . '"><a class="fancybox" href="' . $file_url . '" data-fancybox="gallery" data-caption="' . $mediadesc . '">';
                $fe .= '<img alt="' . $mediatitle . '" src="index.php?rex_media_type=galerie_thumb&rex_media_file=' . $file . '" />';
                $fe .= '</a></div>';
            }

            $be .= '<div class="item"><img src="index.php?rex_media_type=rex_mediapool_preview&rex_media_file=' . $file . '" alt="' . $file . '"></div>';
        }
    }

    if ($art == "thumb") {
        $fe .= '    ]);' . "\n";
        $fe .= '  });' . "\n";
        $fe .= '});' . "\n";
        $fe .= '-->' . "\n";
        $fe .= '</script>';
    }

    $fe .= '</div>';
}

if (!rex::isBackend()) {
    echo $fe;
} else {
    $art_options = array(
        'carpet' => 'Bilderteppich',
        'thumb' => 'Galerie mit Vorschaubild'
    );
    $art_type = $art_options[$art];
    $sort_options = array(
        "natural" => "gemäss Liste",
        "asc" => "Aufsteigend (A-Z)",
        "desc" => "Absteigend (Z-A)"
    );
    $sorting = $sort_options[$sort];
    echo '
 <div id="unite_gallery">
    <div class="form-horizontal output">
     <h2>Galerie</h2>
       <div class="form-group">
         <label class="col-sm-3 control-label">Art der Galerie</label>
         <div class="col-sm-9">
         ' . $art_type . '
         </div>
       </div>
       <div class="form-group">
         <label class="col-sm-3 control-label">Sotierreihenfolge</label>
         <div class="col-sm-9">' . $sorting . '</div>
       </div>';

    echo ' <div class="form-group">
         <label class="col-sm-3 control-label">Bilder</label>
         <div class="col-sm-9">' . $be . '</div>
       </div>';

    echo '</div>
  </div>' . PHP_EOL;
}


?>

<?php
/*
  Der folgende Abschnitt gehört eighentlich nicht in die Modulausgabe.
  Bitte die JS und CSS Dateien selbst im Frontend Template implementieren und diesen Abschnitt hier löschen.
*/
if (!rex::isBackend()) {
    echo '
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
  ';
}


