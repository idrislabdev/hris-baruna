<div id="main-informasi">
        	<div id="main-berita">
            	<div class="main-informasi-judul">Berita Terbaru <span><a href="#" title="lihat semua berita"><img src="../WEB-INF/images/panah-judul-main.png" /></a></span></div>
                <?
                while($informasi->nextRow())
				{
				?>
                <div class="berita-list">
                	<div class="berita-thumb"><img src="../WEB-INF/images/berita-thumb.jpg" /></div>
                    <div class="berita-ket">
                    	<div class="berita-tgl"><?=getFormattedDate($informasi->getField("TANGGAL"))?></div>
                        <div class="berita-isi"><a href="#"><strong><?=truncate($informasi->getField("NAMA"), 6)?></strong>. <span style="font-size:14px;"><?=truncate(dropAllHtml($informasi->getField("KETERANGAN")), 9)?>...</span></a>
                        </div>
                    </div>
                </div>
                <?
				}
				?>
            </div>
            <div id="main-agenda">
            	<div class="main-informasi-judul">Agenda Kegiatan <span><a href="#" title="lihat semua agenda"><img src="../WEB-INF/images/panah-judul-main.png" /></a></span></div>
				<?
                while($agenda->nextRow())
				{
					
				?>
                <div class="agenda-list">
                	<div class="agenda-thumb">
                    	<div class="agenda-tgl"><?=$agenda->getField("TGL")?></div>
                        <div class="agenda-bulan"><?=getNameMonth((int)$agenda->getField("BLN"))?></div>
                    </div>
                    <div class="agenda-ket">
                    	<div class="agenda-isi"><a href="#"><?=truncate(dropAllHtml($agenda->getField("KETERANGAN")), 30)?></a></div>
                    </div>
                </div>
                <?
				}
				?>
            </div>
            <div id="main-rapat">
            	<div class="main-informasi-judul">Hasil Rapat <span><a href="#" title="lihat semua hasil rapat"><img src="../WEB-INF/images/panah-judul-main.png" /></a></span></div>
                <div class="rapat-pdf"><img src="../WEB-INF/images/icon-pdf-besar.png" /></div>
                <div class="rapat-area">
                <?
                while($hasil_rapat->nextRow())
				{
					$hasil_rapat_attachment = new HasilRapatAttachment();
				?>
                	<div class="rapat-list">
                    	<div class="rapat-isi"><?=$hasil_rapat->getField("NAMA")?></div>
                        <?
                        $hasil_rapat_attachment->selectByParams(array("HASIL_RAPAT_ID" => $hasil_rapat->getField("HASIL_RAPAT_ID")));
						$hasil_rapat_attachment->firstRow();
						?>
                        <div class="rapat-download-icon"><a href="pdfviewer.php?reqMode=hasil_rapat&reqId=<?=$hasil_rapat_attachment->getField("HASIL_RAPAT_ATTACHMENT_ID")?>" title="download hasil rapat" target="_blank"><img src="../WEB-INF/images/ArrowDownRed.gif" /></a></div>
                    </div>
                <?
					unset($hasil_rapat_attachment);
				}
				?>    
                </div>
                
            </div>
            <div id="main-faq">
            	<div class="main-informasi-judul">FAQ <span><a href="#" title="lihat semua faq"><img src="../WEB-INF/images/panah-judul-main.png" /></a></span></div>
				<?
                while($faq->nextRow())
				{
				?>
                <div class="faq-list">
                	<div class="faq-tanya"><span>T :</span> <?=$faq->getField("PERTANYAAN")?></div>
                	<div class="faq-jawab"><span>J :</span> <?=$faq->getField("JAWABAN")?></div>
                </div>
                <?
				}
				?>
            </div>
        </div>
        <div id="main-aplikasi">
        	<div id="judul-main-menu">
                <span><img src="../WEB-INF/images/panah-judul.png"> Main Menu</span>
            </div> 

            <div id="content" style="visibility: hidden; clear: both ; margin-top:-20px;">
                <div id="browser_incompatible" class="alert">
                    <button class="close" data-dismiss="alert">Ã—</button>
                    <strong>Warning!</strong>
                    Your browser is incompatible with Droptiles. Please use Internet Explorer 9+, Chrome, Firefox or Safari.
                </div>
                <div id="CombinedScriptAlert" class="alert">
                    <button class="close" data-dismiss="alert">Ã—</button>
                    <strong>Warning!</strong>
                    Combined javascript files are outdated. Please retun the js\Combine.bat file. Otherwise it won't work when you will deploy on a server.    
                </div>
                
                <div id="metro-sections-container" class="metro" style="height:calc(100% - 114px);">
                    <?php /*?><!--<div id="trash" class="trashcan" data-bind="sortable: { data: trash }"></div>--><?php */?>
                    <div class="metro-sections" data-bind="foreach: sections" style="height:calc(100% - 100px);" >
                
                        <div class="metro-section" data-bind="sortable: { data: tiles }">
                            <div data-bind="attr: { id: uniqueId, 'class': tileClasses }">
                                <!-- ko if: tileImage -->
                                <div class="tile-image">
                                    <img data-bind="attr: { src: tileImage }" src="droptiles/img/Internet Explorer.png" />
                                </div>
                                <!-- /ko -->
                
                                <!-- ko if: iconSrc -->
                                <!-- ko if: slides().length == 0 -->
                                <div data-bind="attr: { 'class': iconClasses }">
                                    <img data-bind="attr: { src: iconSrc }" src="droptiles/img/Internet Explorer.png" />
                                </div>
                                <!-- /ko -->
                                <!-- /ko -->
                
                                <div data-bind="foreach: slides">
                                    <div class="tile-content-main">
                                        <div data-bind="html: $data">
                                        </div>
                                    </div>
                                </div>
                
                                <!-- ko if: label -->
                                <span class="tile-label" data-bind="html: label">Label</span>
                                <!-- /ko -->
                
                                <!-- ko if: counter -->
                                <span class="tile-counter" data-bind="html: counter">10</span>
                                <!-- /ko -->
                
                                <!-- ko if: subContent -->
                                <div data-bind="attr: { 'class': subContentClasses }, html: subContent">
                                    subContent
                                </div>
                                <!-- /ko -->
                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END METRO CONTENT -->
            
        </div>