<?php echo $lmenu;?>
<section id="content">
    <section class="vbox">
        <?php echo $inner_head;?>
        <section class="scrollable" id="pjax-container">
            <header>
                <div class="row b-b m-l-none m-r-none">
                    <div class="col-sm-4">
                        <h4 class="m-t m-b-none"><?php echo $this->core->tendoo->getTitle();?></h4>
                        <p class="block text-muted"><?php echo $pageDescription;?></p>
                    </div>
                </div>
            </header>
            <section class="vbox">
                <section class="wrapper w-f"> 
					<?php echo $this->core->notice->parse_notice();?>
                    <?php echo $success;?>
                    <?php echo notice_from_url();?>
                    <div class="row">
                    	<div class="col-lg-8">
                        	<header class="panel-heading text-center">
                                Cr&eacute;er un contr&ocirc;leur
                            </header>
                        	<section class="panel">
                                <form method="post" class="panel-body">
                                    <div class="form-group">
                                    	<label class="label-control">Nom du privil&egrave;ge</label>
                                        <input class="form-control" type="text" name="priv_name" placeholder="Nom du privil&egrave;ge" title="Nom du privil&egrave;ge"/>
                                    </div>
                                    <div class="form-group">
                                    	<label class="label-control">Acc&eacute;ssible au public</label>
                                        <select class="form-control" type="checkbox" name="is_selectable" title="Nom du privil&egrave;ge">
                                        	<option value="">Choisir...</option>
                                        	<option value="0">Indisponible pour le public</option>
                                            <option value="1">Disponible pour le public</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                    	<label class="label-control">Identifiant du privil&egrave;ge</label>
                                        <input class="form-control" type="text" name="priv_encoding" placeholder="Identifiant du privil&egrave;ge" title="Identifiant du privil&egrave;ge" disabled="disabled" value="<?php echo $privId;?>"/>
                                    </div>
                                    <div class="form-group">
                                    	<label class="label-control">Description du privil&egrave;ge</label>
                                        <textarea class="form-control" name="priv_description" placeholder="Description du privil&egrave;ge" title="Description du privil&egrave;ge"></textarea>
                                    </div>
                                    <input class="btn btn-primary" type="submit" value="Cr&eacute;er le privil&egrave;ge" />
                                    <input class="btn btn-danger" type="reset" value="Annuler" />
                                </form>
                            </section>
                        </div>
                        <div class="col-lg-4">
                        	<header class="panel-heading text-center">
                                Plus d'information
                            </header>
<?php
$field_1	=	(form_error('priv_name')) ? form_error('priv_name') : '';
$field_2	=	(form_error('priv_encoding')) ? form_error('priv_encoding') : '';
$field_3	=	(form_error('priv_description')) ? form_error('priv_description') : '';
$field_4	=	(form_error('is_selectable')) ? form_error('is_selectable') : '';
?>
    						<section class="panel">
                            	<div class="wrapper">
                                	<p>Un privil&egrave;ge est un grade qui regroupe un certain nombre d'action. Les actions sont syst&egrave;me et commune. Syst&egrave;me en ce sens o&ugrave; certaines actions natives sont d&eacute;j&agrave; pr&eacute;d&eacute;finies, commune en ce sens o&ugrave; certains modules peuvent ajouter des actions au syst&egrave;me. Vous pouvez attribuer &agrave; un privil&egrave;ge des actions syst&egrave;mes et des actions communes. Le syst&egrave;me de privil&egrave;ge permet de r&eacute;guler les activit&eacute;s des administrateurs.<br /><a href="<?php echo $this->core->url->site_url(array('admin','system','privilege_list'));?>">Administrer les privil&egrave;ges d&eacute;j&agrave; cr&eacute;e ici.</a></p>
									<?php if(strlen($field_1) > 0): echo $field_1;  endif;?>
                                    <?php if(strlen($field_2) > 0): echo $field_2;  endif;?>
                                    <?php if(strlen($field_3) > 0): echo $field_3;  endif;?>
                                    <?php if(strlen($field_4) > 0): echo $field_4;  endif;?>
                            	</div>
                            </section>
                        </div>
					</div>
                </section>
            </section>
        </section>
    </section>