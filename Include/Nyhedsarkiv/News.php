<?php 
	$news_sql = "SELECT News.Title, News.Content FROM News";
	$news_result = mysqli_query($db_conn, $news_sql) or die (mysqli_error($db_conn));
	$total_records = mysqli_num_rows($news_result); // toplam veri sayisi
	$scroll_page = 5; // kaydirilacak sayfa sayisi
	$per_page = 20; // her sayafa gösterilecek sayfa sayisi
	
	if(isset($_GET['npage']))
	{
		$current_page = strip_tags($_GET['npage']); // bulunulan sayfa
	}
	else
	{
		$current_page = 1;
	}
	$pager_url = "index.php?page=$page&npage="; // sayfalamanin yapildigi adres
	$inactive_page_tag = 'id="current_page"'; // aktif olmayan sayfa linki için biçim
	$previous_page_text = '&nbsp;<&nbsp;'; // önceki sayfa metni (resim de olabilir <img src="... gibi)
	$next_page_text = '>&nbsp;'; // sonraki sayfa metni (resim de olabilir <img src="... gibi)
	$first_page_text = '<<'; // ilk sayfa metni (resim de olabilir <img src="... gibi)
	$last_page_text = '>>'; // son sayfa metni (resim de olabilir <img src="... gibi)
	$pager_url_last = ' ';
	
	include("Include/Nyhedsarkiv/kgPager.php");
	$kgPagerOBJ = new kgPager();
	$kgPagerOBJ -> pager_set($pager_url , $total_records , $scroll_page , $per_page , $current_page , $inactive_page_tag , $previous_page_text , $next_page_text , $first_page_text , $last_page_text , $pager_url_last);
	$albums_result = mysqli_query($db_conn,$news_sql." ORDER BY CreatedDate DESC LIMIT ".$kgPagerOBJ -> start.", ".$kgPagerOBJ -> per_page."");
?>
	<div class="col-lg-12 hlpf_newsborder">
<?php
	while ($news_row = mysqli_fetch_assoc($albums_result))
	{
?>
    <div class="drop_shadow" id="news_text">
		<?php echo '<h2>'.$news_row['Title'].' </h2>'; ?>
		<?php echo '<p>'.$news_row['Content'].'</p>'; ?>
        <hr style="clear:both;"/>
    </div>
    <?php }

	echo '<ul class="pagination pagination-lg">';
	

    if($current_page > 1) {
		  echo '<li>'.$kgPagerOBJ -> first_page.'</li>' ;
		  echo '<li>'.$kgPagerOBJ -> previous_page.'</li>' ;
	  } else {
		  echo '<li class="disabled"><a><<</a></li>';
		  echo '<li class="disabled"><a><</a></li>';
	  }
	  echo '<li class="active">'.$kgPagerOBJ -> page_links.'</li>' ;
	  if($current_page >= $kgPagerOBJ -> total_pages) {
		  echo '<li class="disabled"><a>></a></li>';
		  echo '<li class="disabled"><a>>></a></li>';
	  } else {
		  echo '<li>'.$kgPagerOBJ -> next_page.'</li>' ;
		  echo '<li>'.$kgPagerOBJ -> last_page.'</li>' ;
	  }
      echo '</div>';
	 ?>
	 </div>
