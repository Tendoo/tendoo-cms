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
                    <?php echo validation_errors('<p class="error">', '</p>');?>
                    <?php echo notice_from_url();?>
                    <section class="panel">
                        <header class="panel-heading bg-light">
                            <ul class="nav nav-tabs nav-justified">
                                <li class="active"><a href="#datasetting" data-toggle="tab">R&eacute;glages de base</a></li>
                                <li><a href="#autorisation" data-toggle="tab">Autorisations</a></li>
                                <li><a href="#security" data-toggle="tab">S&eacute;curit&eacute;</a></li>
                            </ul>
                        </header>
                        <div class="panel-body">
                            <div class="tab-content">
								<div class="tab-pane active" id="datasetting">
									<form method="post" class="panel-body">
										<div class="form-group">
											<label class="label-control">Modifier le thème du système</label>
											<select class="form-control" name="theme_style">
												<option value="">Choisir le thème</option>
												<option value="0" <?php if((int)$options[0]['ADMIN_THEME'] == 0): ?> selected="selected"<?php endif;?> >Par d&eacute;faut</option>
												<option value="1" <?php if((int)$options[0]['ADMIN_THEME'] == 1): ?> selected="selected"<?php endif;?>>Bubbles Showcase</option>
											</select>
										</div>
										<div class="form-group">
											<label class="control-label">D&eacute;finir fuseau horaire</label>
											<?php $default	=	$options[0]['SITE_TIMEZONE'] == '' ? 'UTC' : $options[0]['SITE_TIMEZONE'];?>
											<select name="newHoraire" class="input-sm form-control">
											<?php $fuso		=	$this->core->tendoo->getFuseau();
											foreach($fuso as $f)
											{
												if($options[0]['SITE_TIMEZONE'] == $f['Code'])
												{
												?>
												<option selected="selected" value="<?php echo $f['Code'];?>"><?php echo $f['Index'].' - '.$f['States'];?></option>
												<?php
												}
												else
												{
													?>
												<option value="<?php echo $f['Code'];?>"><?php echo $f['Index'].' - '.$f['States'];?></option>
													<?php
												}
											}
											?>
											</select>
										</div>                                        
										<div class="form-group">
											<label class="control-label">Nom du site web</label>
											<input type="text" name="newName" class="form-control" value="<?php echo $options[0]['SITE_NAME'];?>">
										</div>
										<div class="form-group">
											<label class="control-label">Lien vers logo</label>
											<input type="text" name="newLogo" class="form-control">
										</div>
										<div class="form-group">
											<?php
											$format	=	$options[0]['SITE_TIMEFORMAT'];
											?>
											<label class="control-label">D&eacute;finir format horaire</label>
											<select name="newFormat" class="input-sm form-control inline">
												<option value="">Choisir...</option>
												<option <?php echo $format == 'type_1' ? 'selected="selected"' : '';?> value="type_1">J m A (29 Juin 2013)</option>
												<option <?php echo $format == 'type_2' ? 'selected="selected"' : '';?> value="type_2">J/m/A (29/06/2013)</option>
												<option <?php echo $format == 'type_3' ? 'selected="selected"' : '';?> value="type_3">A/m/J (2013/06/29)</option>
											</select>
										</div>
										<input class="btn btn-sm btn-primary" type="submit" value="Enregistrer"/>
									</form>
								</div>
								<div class="tab-pane" id="autorisation">
									<?php echo tendoo_warning('Veuillez patienter la notification de r&eacute;ssite, confirmant l\'enregistrement des modifications.');?>
									<div class="row">
										<div class="col-lg-4">
											<h3>Principales Autorisations</h3>
											<form fjax method="post" action="<?php echo $this->core->url->site_url(array('admin','ajax','toggleAdminStats'));?>">
												<div class="form-group">
													<label>
														<?php 
														if($options[0]['SHOW_ADMIN_INDEX_STATS'] == "1")
														{
														?>
														<input type="submit" name="showAdminStats" class="btn btn-primary" value="Cacher les statistiques &agrave; l'accueil">
														<?php
														}
														else
														{
														?>
														<input type="submit" name="showAdminStats" class="btn btn-primary" value="Afficher les statistiques à l'accueil">
														<?php
														}
														;?>
													</label>
													<script>
													$(document).ready(function(){
														$('[name="showAdminStats"]').bind('click',function(){
															if($(this).val() == 'Afficher les statistiques à l\'accueil')
															{
																$(this).attr('value','Cacher les statistiques à l\'accueil');
															}
															else
															{
																$(this).attr('value','Afficher les statistiques à l\'accueil');
															}
														});
													});
													</script>
												</div>
											</form>
											<form fjax method="post" action="<?php echo $this->core->url->site_url(array('admin','ajax','toogleStoreAccess'));?>">
												<div class="form-group">
													<label>
														<?php 
														if($options[0]['CONNECT_TO_STORE'] == "1")
														{
														?>
														<input type="submit" name="storeToggle" class="btn btn-primary" value="Désactiver la connexion au Store">
														<?php
														}
														else
														{
														?>
														<input type="submit" name="storeToggle" class="btn btn-primary" value="Activer la connexion au Store">
														<?php
														}
														;?>
													</label>
													<script>
													$(document).ready(function(){
														$('[name="storeToggle"]').bind('click',function(){
															if($(this).val() == 'Activer la connexion au Store')
															{
																$(this).attr('value','Désactiver la connexion au Store');
															}
															else
															{
																$(this).attr('value','Activer la connexion au Store');
															}
														});
													});
													</script>
												</div>
											</form>
											<form fjax method="post" action="<?php echo $this->core->url->site_url(array('admin','ajax','toggleFirstVisit'));?>">
												<div class="form-group">
													<label>
														<?php 
														if($options[0]['FIRST_VISIT'] == "1")
														{
														?>
														<input type="submit" name="firstVisitToggle" class="btn btn-primary" value="Cacher la visite guidée">
														<?php
														}
														else
														{
														?>
														<input type="submit" name="firstVisitToggle" class="btn btn-primary" value="Afficher la visite guidée">
														<?php
														}
														;?>
													</label>
													<script>
													$(document).ready(function(){
														$('[name="firstVisitToggle"]').bind('click',function(){
															if($(this).val() == 'Cacher la visite guidée')
															{
																$(this).attr('value','Afficher la visite guidée');
															}
															else
															{
																$(this).attr('value','Cacher la visite guidée');
															}
														});
													});
													</script>
												</div>
											</form>
											<form fjax method="post" action="<?php echo $this->core->url->site_url(array('admin','ajax','toggleWelcomeMessage'));?>">
												<div class="form-group">
													<label>
														<?php 
														if($options[0]['SHOW_WELCOME'] == "TRUE")
														{
														?>
														<input type="submit" name="welcomeToggle" class="btn btn-primary" value="Cacher le message de bienvenue">
														<?php
														}
														else
														{
														?>
														<input type="submit" name="welcomeToggle" class="btn btn-primary" value="Afficher le message de bienvenue">
														<?php
														}
														;?>
													</label>
													<script>
													$(document).ready(function(){
														$('[name="welcomeToggle"]').bind('click',function(){
															if($(this).val() == 'Afficher le message de bienvenue')
															{
																$(this).attr('value','Cacher le message de bienvenue');
															}
															else
															{
																$(this).attr('value','Afficher le message de bienvenue');
															}
														});
													});
													</script>
												</div>
											</form>
										</div>
										<div class="col-lg-8">
											<h3>Icones et applications</h3>
											<form method="post">
												<div class="form-group">
													<label class="control-label">Liste d'icones disponibles</label>
													<div class="panel">
														<table class="table">
															<thead>
																<th>Module</th>
																<th>Nom de l'icone</th>
																<th width="180">Afficher à l'accueil</th>
															</thead>
															<tbody>
															<input type="hidden" name="showIcon[]" value="" />
																<?php
																if($appIconApi)
																{
																	foreach($appIconApi as $_a)
																	{
																		
																			eval($options[0]['ADMIN_ICONS']);
																			if(!isset($icons))
																			{
																				$icons	=	array(0);
																			}
																			$visibleIcons	=	$icons;
																			$val	=	'';
																			foreach($visibleIcons as $s)
																			{
																				if($s	===	$_a['ICON_MODULE']['NAMESPACE'].'/'.$_a['ICON_NAMESPACE'])
																				{
																					$val	=	'checked="checked"';
																					break;
																				}
																			}
																				
																		?>
																		<td><?php echo $_a['ICON_HUMAN_NAME'];?></td>
																		<td><?php echo $_a['ICON_MODULE']['HUMAN_NAME'];?></td>
													<td><label class="label-control switch">
														<input type="checkbox" name="showIcon[]" <?php echo $val;?>  value="<?php echo $_a['ICON_MODULE']['NAMESPACE'].'/'.$_a['ICON_NAMESPACE'];?>"  />
														<span style="height:20px;"></span>
													</label></td>
													<?php
																		
																	}
																}
																else
																{
																	?>
													<td colspan="2">Aucune icone disponible</td>
													<?php
																}
																?>
															</tbody>
														</table>
													</div>
												</div>
												<input name="appicons" class="btn btn-sm btn-primary" type="submit" value="Enregistrer"/>
											</form>
                                    
										</div>
										
									</div>
                                </div>
								<div class="tab-pane" id="security">
									<div class="row">
										<div class="col-lg-8">
											<?php
											$checked	=	($options[0]['ALLOW_PRIVILEGE_SELECTION'] == "1") ? 'checked="checked"' : "";
											?>
											<form method="post">
												<h3>Privil&egrave;ges</h3>
												<div class="form-group">
													<label class="label-control">Autoriser la selection des privilèges: <input class="input-control" name="allow_priv_selection" type="checkbox" value="1" style="min-width:20px;" <?php echo $checked;?> /></label>                                                <p>Vous avez la possibilité de définir parmis les privilèges que vous avez cr&eacute;e, ceux qui sont disponible d&egrave;s l'inscription par les utilisateurs. N'oubliez pas de choisir parmis les privil&egrave;ges que vous avez cr&eacute;es ceux qui seront acc&eacute;sible au public. </p>
												</div>
												<input name="allow_priv_selection_button" class="btn btn-sm btn-primary" type="submit" value="Enregistrer"/>
											</form>
											<br>
											<form method="post" >
												<div class="form-group">
													<label class="label-control">Ouvrir l'acc&egrave;s &agrave; l'administration aux privil&egrave;ges publics</label>
													<p>Il est important de savoir que cette option emp&ecirc;che &agrave; tout utilisateur faitsant partie des privil&egrave;ge ouvert au public, d'acc&eacute;der &agrave; l'espace administration, sans consid&eacute;rer le fait que des actions aient &eacute;t&eacute; ajout&eacute;es aux diff&eacute;rents privil&egrave;ges acc&eacute;ssible au public. Pareillement, lorsqu'un privil&egrave;ge cesse s'&ecirc;tre acc&eacute;ssible au public, tout utilisateur faisant partie de ce privil&egrave;ge pourra d&eacute;sormais acc&eacute;der &agrave; l'espace administration.</p>
													<select name="publicPrivAccessAdmin" class="form-control">
														<option value="">Choisir...</option>
														<?php
														if($options[0]['PUBLIC_PRIV_ACCESS_ADMIN'] == 0)
														{
															?>
														<option value="1">Oui</option>
														<option selected="selected" value="0">Non</option>
															<?php
														}
														else if($options[0]['PUBLIC_PRIV_ACCESS_ADMIN'] == 1)
														{
															?>
														<option selected="selected" value="1">Oui</option>
														<option value="0">Non</option>
															<?php
														}
														else
														{
															?>
														<option value="1">Oui</option>
														<option value="0">Non</option>
															<?php
														}
														?>
													</select>
												</div>
												<input name="publicPrivAccessAdmin_button" class="btn btn-sm btn-primary" type="submit" value="Enregistrer"/>
											</form>
										</div>
										<div class="col-lg-4">
											<form method="post">
												<h3>Inscription</h3>
												<div class="form-group">
													<label class="label-control">Autoriser les inscription</label>
													<select name="allowRegistration" class="form-control">
														<option value="">Choisir...</option>
														<?php
														if($options[0]['ALLOW_REGISTRATION'] == 0)
														{
															?>
														<option value="1">Oui</option>
														<option selected="selected" value="0">Non</option>
															<?php
														}
														else if($options[0]['ALLOW_REGISTRATION'] == 1)
														{
															?>
														<option selected="selected" value="1">Oui</option>
														<option value="0">Non</option>
															<?php
														}
														else
														{
															?>
														<option value="1">Oui</option>
														<option value="0">Non</option>
															<?php
														}
														?>
													</select>
												</div>
												<input name="autoriseRegistration" class="btn btn-sm btn-primary" type="submit" value="Enregistrer"/>
											</form>
										</div>
									</div>
								</div>
                                
                                <div class="tab-pane" id="otherSetting">
                                	<div class="col-lg-6">
                                        
										
                                        
                                        </div>
                                	<div class="col-lg-6">
                                        
										
                                    </div>
                                </div>
                               <div class="tab-pane" id="icons">
                                	<div class="wrapper">
                                    </div>
                                </div> 
                            </div>
                        </div>
                    </section>
                </section>
            </section>
        </section>
    </section>
    <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> </section>