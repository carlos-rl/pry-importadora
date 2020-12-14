<div class="row">
    <input type="hidden" name="id" id="id_" value="">
    <input type="hidden" name="action" id="action" value="add">
    <?php 
        $num = count($attrform);
        $column = 'col-md-12';
        if(!isset($row)){
            if($num === 1){
                $column = 'col-md-12';
            }else{
                if(($num > 1) and ($num < 9)){
                    $column = 'col-md-6';
                }
                if($num > 9){
                    $column = 'col-md-4';
                }
            }
        }
        
    ?>
    <?php for ($i = 0; $i < count($attrform); $i++) { ?>
        
        <div class="<?= $column ?>">
            <?php $ins = $attrform[$i]; ?>
            
            <?php if ($ins['type'] == 'hidden') { ?>
                <input type="<?= $ins['type'] ?>" name="<?= $ins['name'] ?>" value="<?= $ins['value'] ?>"  id="<?= $ins['name'] ?>">
            <?php } ?>
            <?php if ($ins['type'] == 'text' || $ins['type'] == 'email' || $ins['type'] == 'password') { ?>
                <div class="form-group">
                    <label for="<?= $ins['name'] ?>">
                        <font style="vertical-align: inherit;">
                        <font style="vertical-align: inherit;"><?= $ins['title'] ?></font>
                        </font>
                    </label>
                    <input  autocomplete="off" type="<?= $ins['type'] ?>" name="<?= $ins['name'] ?>" value="<?= $ins['value'] ?>" required="<?= ($ins['requerido']==false?'false':'') ?>" id="<?= $ins['name'] ?>" maxlength="<?= $ins['max'] ?>" class="form-control">
                    <datalist id="<?= $ins['name'] ?>_list">
                    </datalist>
                </div>
            <?php } ?>
            <?php if ($ins['type'] == 'datalist') { ?>
                <div class="">
                    <label for="<?= $ins['name'] ?>">
                        <font style="vertical-align: inherit;">
                        <font style="vertical-align: inherit;"><?= $ins['title'] ?></font>
                        </font>
                    </label>
                    <div class="input-group" style="padding-bottom: 15px;">
                        <input placeholder="<?= $ins['title'] ?>" autocomplete="off" type="text" name="<?= $ins['name'] ?>" value="<?= $ins['value'] ?>" required="<?= ($ins['requerido']==false?'false':'') ?>" id="<?= $ins['name'] ?>" maxlength="<?= $ins['max'] ?>" class="form-control">
                        <div class="input-group-addon">
                            <i class="fa fa-angle-down"></i>
                        </div>
                        <div class="input-group-btn">
                            <a title="Agregar otro" href="<?= base_url() ?><?= $ins['url'] ?>" target="_blank" class="btn btn-default"><i class="fa fa-plus"></i></a>
                        </div>
                    </div>
                    <datalist id="<?= $ins['name'] ?>_list">
                    </datalist>
                </div>
            <?php } ?>
            <?php if ($ins['type'] == 'textarea') { ?>
                <div class="form-group">
                    <label for="<?= $ins['name'] ?>">
                        <font style="vertical-align: inherit;">
                        <font style="vertical-align: inherit;"><?= $ins['title'] ?></font>
                        </font>
                    </label>
                    <textarea maxlength="<?= $ins['max'] ?>" name="<?= $ins['name'] ?>" id="<?= $ins['name'] ?>" rows="4" cols="<?= $ins['max'] ?>" class="form-control textarea_auto"><?= (!isset($ins['value'])?'':$ins['value']) ?></textarea>
                </div>
            <?php } ?>
            <?php if ($ins['type'] == 'time') { ?>
                <div class="bootstrap-timepicker">
                    <div class="form-group">
                        <label for="<?= $ins['name'] ?>">
                            <font style="vertical-align: inherit;">
                            <font style="vertical-align: inherit;"><?= $ins['title'] ?></font>
                            </font>
                        </label>
                        <div class="input-group">
                            <input type="text" name="<?= $ins['name'] ?>" value="<?= $ins['value'] ?>" required="<?= ($ins['requerido']==false?'false':'') ?>" id="<?= $ins['name'] ?>" maxlength="<?= $ins['max'] ?>" class="form-control timepicker">
                            <div class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <?php if ($ins['type'] == 'date') { ?>
                <div class="bootstrap-timepicker">
                    <div class="form-group">
                        <label for="<?= $ins['name'] ?>">
                            <font style="vertical-align: inherit;">
                            <font style="vertical-align: inherit;"><?= $ins['title'] ?></font>
                            </font>
                        </label>
                        <div class="input-group date">
                            <input type="text" name="<?= $ins['name'] ?>" value="<?= $ins['value'] ?>" required="<?= ($ins['requerido']==false?'false':'') ?>" id="<?= $ins['name'] ?>" maxlength="<?= $ins['max'] ?>" class="form-control timepicker">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <?php if ($ins['type'] == 'select') { ?>
                <div class="form-group">
                    <label for="<?= $ins['name'] ?>">
                        <font style="vertical-align: inherit;">
                        <font style="vertical-align: inherit;"><?= $ins['title'] ?></font>
                        </font>
                    </label>
                    <select name="<?= $ins['name'] ?>" style="width: 100%" required="<?= ($ins['requerido']==false?'false':'') ?>" id="<?= $ins['name'] ?>" class="form-control">
                        <?php for ($j = 0; $j < count($ins['option']); $j++) { ?>
                            <option <?= ($ins['option'][$j]['attr']['text']) ?>=<?= ($ins['option'][$j]['attr']['value']) ?> value="<?= $ins['option'][$j]['value'] ?>"  >
                                <?= $ins['option'][$j]['text'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
</div>
<div class="row">
    <div class="col-md-12">
        <button class="btn btn-primary" type="submit" id="boton_submit">
            <span id="loading" class="fa fa-save"></span>
            <span id="caption">Crear Registro</span>
        </button>
        <button class="btn btn-default" type="button" id="cancelar">
            <font style="vertical-align: inherit;">
            <font style="vertical-align: inherit;">Cancelar</font>
            </font>
        </button>
    </div>

</div>