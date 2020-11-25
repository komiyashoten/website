<?php get_header(); ?>
<section class="daily_use">
	<div class="du_top_header">
		<div class="text">
			<h2 class="logo"><img src="/wp-content/themes/komiya/img/du-logo.png" width="195" alt="小宮商店 Daily Use Umbrella"></h2>
			<h3>まいにちを、もっと快適にする<br>
			小宮商店企画の海外製の傘</h3>
		</div>
		<div class="black">&nbsp;</div>
		<div class="bg"><img src="/wp-content/themes/komiya/img/du001.jpg"></div>
	</div>
	<?php 
	$page_id = get_page_by_path("daily-use-umbrella");
	$page_id = $page_id->ID;
	?>
	<section class="bgcolor1 wrap_du_top_series_list">
		<p class="du_top_lead center">持ってないみたいに軽い傘、自動で開け閉めができる傘、おちょこになっても元に戻る傘。<br>
		「こんな傘があったらいいな」を実現するため、傘に革新的なアイデアを取り込み、とことん「機能」にこだわりました。<br>
		様々なライフスタイルに合わせて、もっと快適にお使いいただける傘を目指して、<br>
		小宮商店が企画した海外製の傘が、「小宮商店 Daily Use Umbrella」の傘です。</p>
		<p class="du_top_lead center" style="margin-bottom: 1.2em;">以下のオンラインショップでお買い求めいただけます。</p>
		<div class="du_online_shops"><a href="https://www.amazon.co.jp/s?me=A2H72AY1Q15C3Z&marketplaceID=A1VC38T7YXB528">Amazon店</a><a href="https://store.shopping.yahoo.co.jp/komiya/">Yahoo!ショッピング店</a></div>
		<ul class="du_top_series_list">
			<?php 
			$page_list = new WP_Query([ 'post_type' =>'page', 'post_parent' => $page_id, 'posts_per_page' => 100, 'order' => 'ASC' ]);
			if ( $page_list->have_posts() ):
				 while ( $page_list->have_posts() ) : $page_list->the_post(); ?>
				<li>
					<a href="<?php the_permalink(); ?>">
						<div><?php the_post_thumbnail('medium'); ?></div>
						<div class="text">
							<h3><?php the_title(); ?></h3>
							<div class="tags"><?php echo get_my_term_list( $post->ID, 'du_tag', '<span> ', '</span><span>', '</span>','' ); ?></div>
						</div>
					</a>
				</li>
				 <?php
				endwhile;
			endif;
			?>
		</ul>
	</section>
</section>
<section class="du_header">
		<ul class="tags">
			<?php
				$terms = get_terms('du_tag');
				foreach ( $terms as $term ) {
				echo '<a href="'.get_term_link($term).'">'.$term->name.'</a>';}
			?>
		</ul>
</section>
<?php include 'brand-big-banner.php'; ?>
<?php get_footer(); ?>