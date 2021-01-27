			<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.php">Admin</a>
                </div>

                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    
                </button>

                <ul class="nav navbar-nav navbar-left navbar-top-links">
                    <li><a href="http://presensi.arira.id/index.php" target="_blank"><i class="fa fa-home fa-fw"></i> Website</a></li>
                </ul>

                <ul class="nav navbar-right navbar-top-links">
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
						<?php $nama_nya = explode(" ", $nama_user) ?>
                            <i class="fa fa-user fa-fw"></i> <?php echo $nama_nya[0]; ?> <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="profile.php"><i class="fa fa-user fa-fw"></i> User Profile</a></li>
                            <li class="divider"></li>
                            <li><a href="?q=logout" onclick='return confirm("Apakah Yakin Ingin Logout?")'><i class="fa fa-sign-out fa-fw"></i> Keluar</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <!-- /.navbar-top-links -->

                <div class="navbar-default sidebar" role="navigation">
                    <div class="sidebar-nav navbar-collapse">
                        <ul class="nav" id="side-menu">
                            <li>
                                <a href="index.php" class="active"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-table fa-fw"></i> Data<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="data_presensi.php">Presensi</a>
                                    </li>
                                    <li>
                                        <a href="data_rules.php">Rules</a>
                                    </li>
									<?php 
										if($jenis_user=="A"){
									?>
                                    <li>
                                        <a href="data_users.php">Users</a>
                                    </li>
									<?php 
										}
									?>
                                </ul>
                            </li>
							<?php 
								$jmldata = $db->cek_navigasi_lap($iduser);
								if($jmldata != 0){
							?>
							<li>
                                <a href="#"><i class="fa fa-book fa-fw"></i> Laporan<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="lap_presensi.php?filter=today">Presensi Hari Ini</a>
                                    </li>
									<?php
									  $data_nav = $db->navigasi_lap($iduser);
									  foreach($data_nav as $nav){
										  echo "<li><a href='lap_presensi.php?filter=select&idrule=$nav[idrule]'>Presensi $nav[nama_mapel] ($nav[tingkat])</a></li>";
									  }
									?>
                                </ul>
                            </li>
							<?php
								}
							?>
                        </ul>
                    </div>
                </div>
            </nav>