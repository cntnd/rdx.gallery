<?php
$sort = 'REX_VALUE[2]';
?>
<script>
    $(document).ready(function () {
        $('#gallery_type').change(function() {
            var type = $(this).val();
            var show = (type==="thumb") ? "show" : "hide";
            $("#gallery_type_thumb").collapse(show);
        });

        $('#comment').change(function() {
            var show = $(this).val();
            $("#comment_content").collapse(show);
        });
    });
</script>
<div id="cntnd_gallery">
    <div class="form-horizontal">
        <h4>Bildergalerie</h4>
        <div class="form-group">
            <label class="col-sm-3 control-label" for="headline">Bilder</label>
            <div class="col-sm-9">
                REX_MEDIALIST[id="1" widget="1"]
            </div>
        </div>

        <h4>Einstellungen</h4>
        <div class="form-horizontal">
            <div class="form-group">
                <label class="col-sm-3 control-label" for="headline-level">Art der Galerie</label>
                <div class="col-sm-9">
                    <?php
                    // Bilderteppich, Galerie mit Vorschaubild
                    $options = array(
                        'carpet' => 'Bilderteppich',
                        'thumb' => 'Galerie mit Vorschaubild'
                    );
                    ?>
                    <div class="rex-select-style">
                        <select name="REX_INPUT_VALUE[1]" id="gallery_type" class="form-control">
                            <?php foreach ($options as $k => $v) : ?>
                                <option value="<?php echo $k; ?>"<?php if ($k == "REX_VALUE[1]") echo ' selected="selected"' ?>><?php echo $v; ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
            </div>
            <?php
            $galery_type = 'REX_VALUE[1]';
            ?>

            <div class="form-group collapse <?php if($galery_type=="carpet") { echo "in"; } ?>" id="gallery_type_carpet">
                <label class="col-sm-3 control-label">Bilderteppich</label>
                <div class="col-sm-9">
                    <div class="mb-3">
                        <label for="carpetContainer" class="form-label">CSS Klasse Bilderteppich Container</label>
                        <input type="text" class="form-control" id="carpetContainer" name="REX_INPUT_VALUE[5]" value="REX_VALUE[5]" placeholder="unigrid--row">
                    </div>

                    <div class="mb-3">
                        <label for="carpetContainerItem" class="form-label">CSS Klasse Bilderteppich Bild</label>
                        <input type="text" class="form-control" id="carpetContainerItem" name="REX_INPUT_VALUE[6]" value="REX_VALUE[6]"  placeholder="brick brick-6">
                    </div>
                </div>
            </div>

            <div class="form-group collapse <?php if($galery_type=="thumb") { echo "in"; } ?>" id="gallery_type_thumb">
                <label class="col-sm-3 control-label">Vorschaubild</label>
                <div class="col-sm-9">
                    <?php
                    $imagelist = explode(',', "REX_MEDIALIST[1]");
                    if ($sort == "asc") {
                        asort($imagelist);
                    } else if ($sort == "desc") {
                        arsort($imagelist);
                    }
                    ?>
                    <div class="rex-select-style">
                        <select name="REX_INPUT_VALUE[7]" id="sort" class="form-control">
                            <?php foreach ($imagelist as $v) : ?>
                                <option value="<?php echo $v; ?>"<?php if ($v == "REX_VALUE[7]") echo ' selected="selected"' ?>><?php echo $v; ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label">Sortierreihenfolge</label>
                <div class="col-sm-9">
                    <?php
                    $sort_options = array(
                        "natural" => "gemäss Liste",
                        "asc" => "Aufsteigend (A-Z)",
                        "desc" => "Absteigend (Z-A)"
                    );
                    ?>
                    <div class="rex-select-style">
                        <select name="REX_INPUT_VALUE[2]" id="sort" class="form-control">
                            <?php foreach ($sort_options as $k => $v) : ?>
                                <option value="<?php echo $k; ?>"<?php if ($k == "REX_VALUE[2]") echo ' selected="selected"' ?>><?php echo $v; ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label">Kommentare</label>
                <div class="col-sm-9">
                    <?php
                    $options = array(
                        "hide" => "keine Kommentare",
                        "show" => "Kommentare anzeigen"
                    );
                    ?>
                    <div class="rex-select-style">
                        <select name="REX_INPUT_VALUE[3]" id="comment" class="form-control">
                            <?php foreach ($options as $k => $v) : ?>
                                <option value="<?php echo $k; ?>"<?php if ($k == "REX_VALUE[3]") echo ' selected="selected"' ?>><?php echo $v; ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $comment_collapsed = 'REX_VALUE[3]';
        ?>
        <div id="comment_content" class="collapse <?php if($comment_collapsed=="show") { echo "in"; } ?>">
            <div class="panel-heading collapsed" data-toggle="collapse" data-target="#collapse-comment"
                 style="padding-left: 0;">
                <strong>Kommentare</strong> <span class="caret"></span>
            </div>
            <div id="collapse-comment" class="panel-collapse collapse in" style="max-height: 300px; overflow-y: scroll; overflow-x: hidden;">
                <div class="form-horizontal">
                    <?php
                    if ("REX_MEDIALIST[1]" != '') {
                        $imagelist = explode(',', "REX_MEDIALIST[1]");
                        if ($sort == "asc") {
                            asort($imagelist);
                        } else if ($sort == "desc") {
                            arsort($imagelist);
                        }
                        $values = rex_var::toArray('REX_VALUE[4]');
                        foreach ($imagelist as $image) {
                            $v = isset($values[$image]) ? $values[$image] : "";
                            echo '<div class="form-group">';
                            echo '<label class="col-sm-3 control-label">' . $image . '</label>';
                            echo '<div class="col-sm-8"><input class="form-control" name="REX_INPUT_VALUE[4][' . $image . ']" value="' . $v . '" type="text" /></div>';
                            echo '</div>';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
