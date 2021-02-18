<?php
/*
Template Name: GIFT
Template Post Type: post, page
*/
?>
<?php get_header(); ?>

<section class="about">
	<div class="page_header">
		<h2><?php the_title(); ?></h2>
		<div class="black">&nbsp;</div>
		<img src="/wp-content/themes/komiya/img/gift005.jpg">
	</div>
    <section class="site_width_inner">
		<section class="margin1 center">
			<h3>傘は、末広がりの縁起物</h3>
			<p>もらってうれしい、縁起もいい。<br>
			そんな傘を大切な方への贈り物にいかがですか？<br>
			<br>
			プレゼント用に小宮商店の傘をお求めいただきましたら、<br>
			専用のギフトボックスにて、丁寧にお包みいたします。<br>
			記念日や季節の贈り物にはおリボンを、<br>
			ご栄転やご卒業などの節目のお祝いには<br>
			お熨斗をおかけいたします。</p>
		</section>
		<div class="section_title2">男性に贈る傘</div>
		<section class="margin2 center">
			<p>いいスーツ、いい鞄、いい時計、いい靴は持ってるけど、傘は使い捨て。<br>
			そんな男性に贈る「いい傘」。</p>
		</section>
		<section class="margin2 center">
			<div><img src="/wp-content/themes/komiya/img/gift001.jpg" class="center" width="790"></div>
		</section>
		<div class="thumbnail_set3 margin1">
			<ul>
			<?php query_posts( array(
				'post_type' => 'product', //カスタム投稿名を指定
				'taxonomy' => 'product_tag',     //タクソノミー名を指定
				'term' => 'present_for_men',           //タームのスラッグを指定
				'posts_per_page' => 3      ///表示件数（-1で全ての記事を表示）
			)); ?>
			<?php if(have_posts()): ?>
			<?php while(have_posts()):the_post(); ?>
			<li><a href="<?php echo post_custom('商品ページURL'); ?>">
				<div class="thumbnail"><?php the_post_thumbnail('thumbnail'); ?></div>
				<div class="titile"><?php echo post_custom('シリーズ名'); ?>&nbsp;&nbsp;<span><?php $terms = get_the_terms($post->ID, 'size'); foreach ($terms as $term) : ?><?php echo $term->name; ?><?php endforeach; ?>&nbsp;<?php $terms = get_the_terms($post->ID, 'ribs'); foreach ($terms as $term) : ?><?php echo $term->name; ?><?php endforeach; ?></span></div>
				<div class="spec">
					<?php echo post_custom('大分類'); ?>
				</div>
				<div class="price">¥<?php echo custom_post_custom('値段'); ?></div>
			</a></li>
			<?php endwhile; else: ?>
			商品が見つかりません。
			<?php endif; ?>
			<?php wp_reset_query(); ?>
			</ul>
		</div>
		<div class="section_title2">女性に贈る傘</div>
		<section class="margin2 center">
			<p>晴れの日、曇りの日、雨の日、天気やファッションに合わせて、傘でおしゃれを楽しみたい。<br>
			そんな女性に贈る「いい傘」。</p>
		</section>
		<section class="margin2 center">
			<div><img src="/wp-content/themes/komiya/img/gift002.jpg" class="center" width="790"></div>
		</section>
		<div class="thumbnail_set3 margin1">
			<ul>
			<?php query_posts( array(
				'post_type' => 'product', //カスタム投稿名を指定
				'taxonomy' => 'product_tag',     //タクソノミー名を指定
				'term' => 'present_for_women',           //タームのスラッグを指定
				'posts_per_page' => 3      ///表示件数（-1で全ての記事を表示）
			)); ?>
			<?php if(have_posts()): ?>
			<?php while(have_posts()):the_post(); ?>
			<li><a href="<?php echo post_custom('商品ページURL'); ?>">
				<div class="thumbnail"><?php the_post_thumbnail('thumbnail'); ?></div>
				<div class="titile"><?php echo post_custom('シリーズ名'); ?>&nbsp;&nbsp;<span><?php $terms = get_the_terms($post->ID, 'size'); foreach ($terms as $term) : ?><?php echo $term->name; ?><?php endforeach; ?>&nbsp;<?php $terms = get_the_terms($post->ID, 'ribs'); foreach ($terms as $term) : ?><?php echo $term->name; ?><?php endforeach; ?></span></div>
				<div class="spec">
					<?php echo post_custom('大分類'); ?>
				</div>
				<div class="price">¥<?php echo custom_post_custom('値段'); ?></div>
			</a></li>
			<?php endwhile; else: ?>
			商品が見つかりません。
			<?php endif; ?>
			<?php wp_reset_query(); ?>
			</ul>
		</div>
		<div class="section_title2">ペアで贈る傘</div>
		<section class="margin2 center">
			<p>二人の門出を祝して、新生活をもっと豊かに。<br>
			ご結婚のお祝いに贈る「いい傘」。</p>
		</section>
		<section class="margin2 center">
			<div><img src="/wp-content/themes/komiya/img/gift003.jpg" class="center" width="790"></div>
		</section>
		<div class="thumbnail_set3 margin1">
			<ul>
			<?php query_posts( array(
				'post_type' => 'product', //カスタム投稿名を指定
				'taxonomy' => 'product_tag',     //タクソノミー名を指定
				'term' => 'present_for_couple',           //タームのスラッグを指定
				'posts_per_page' => 3      ///表示件数（-1で全ての記事を表示）
			)); ?>
			<?php if(have_posts()): ?>
			<?php while(have_posts()):the_post(); ?>
			<li><a href="<?php echo post_custom('商品ページURL'); ?>">
				<div class="thumbnail"><?php the_post_thumbnail('thumbnail'); ?></div>
				<div class="titile"><?php echo post_custom('シリーズ名'); ?>&nbsp;&nbsp;<span><?php $terms = get_the_terms($post->ID, 'size'); foreach ($terms as $term) : ?><?php echo $term->name; ?><?php endforeach; ?>&nbsp;<?php $terms = get_the_terms($post->ID, 'ribs'); foreach ($terms as $term) : ?><?php echo $term->name; ?><?php endforeach; ?></span></div>
				<div class="spec">
					<?php echo post_custom('大分類'); ?>
				</div>
				<div class="price">¥<?php echo custom_post_custom('値段'); ?></div>
			</a></li>
			<?php endwhile; else: ?>
			商品が見つかりません。
			<?php endif; ?>
			<?php wp_reset_query(); ?>
			</ul>
		</div>
		<span id="wholesale" style="line-height: 0;">&nbsp;</span>
		<div class="section_title2">大口ギフトのご依頼も承ります。</div>
		<section class="margin2 center">
			<p>学校の卒業記念、会社の創立記念などの贈り物に<br>
			オリジナル傘のプレゼントはいかがでしょうか？<br>
			<br>
			「小宮商店」の傘は手元（持ち手）に名入れをして<br>
			一点ものの特別な傘に仕上げることが出来ます。<br>
			「小宮商店 Daily Use Umbrella」の傘には、<br>
			お名前やロゴを傘生地にプリントし、<br>
			オリジナルのデザインに仕上げます。<br>
			<br>
			一本一本、個別にご包装をいたしますので、<br>
			到着後はそのまま先様へお渡しいただけます。<br>
			<br>
			小ロットから承っておりますので<br>
			お気軽にご相談くださいませ。</p>
		</section>
    </section>
</section>
<section class="bgcolor1" style=" font-size: 1vw; padding: 5em 5em 0 5em;">
	<h2 class="blog_section_title">BLOG
	<div class="sub">贈り物・プレゼント</div></h2>
	<ul class="blog_list2_3">
		<?php
			$args = array(
				'post_type' => 'post',
				'category_name' => 'present',
				'orderby' => 'post_date',
				'order' => 'DESC',
				'post_status' => 'publish'
			);
			$st_query = new WP_Query( $args );
		?>
	<?php if ( $st_query->have_posts() ): ?>
	<ul class="blog_list2_3">
		<?php while ( $st_query->have_posts() ) : $st_query->the_post(); ?>
			<li><?php if(has_post_thumbnail()): ?>
				<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('medium'); ?>
			<?php else: ?>
				<a href="<?php the_permalink(); ?>"><img src="/wp-content/themes/komiya/img/atari.jpg">
			<?php endif; ?>
			<div class="blog_date_category"><span class="date"><?php the_time('Y.m.d'); ?></span> ｜ <span class="category"><?php $cat = get_the_category(); $cat = $cat[0]; { echo $cat->cat_name; } ?></span></div>
			<h3><?php the_title(); ?></h3></a></li>
		<?php endwhile; ?>
	</ul>
	<?php endif; ?>
	<?php wp_reset_query(); ?>
</section>

<?php get_footer(); ?>