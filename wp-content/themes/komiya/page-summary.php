<?php
/*
Template Name: まとめ一覧ページ
Template Post Type: post, page
*/
global $post;
?>
<?php get_header('top'); ?>
<?php if(have_posts()): while(have_posts()):the_post(); ?>
	<section id="summary_header">
		<img src="<?php echo kmy_get_thumbnail(get_the_ID()); ?>">
		<div class="summary_titles">
			<div class="category"><?php the_category(', ');?></div>
			<h1><?php echo get_post_meta(get_the_ID(),'まとめ英語タイトル',true); ?>
				<span><?php echo get_post_meta(get_the_ID(),'まとめ日本語タイトル',true); ?></span>
			</h1>
		</div>
	</section>
	<?php
		//まとめページに属し、なおかつ現在表示中の性別用途の記事を出す
		$args = array(
			'number_posts'    => 5,
			'posts_per_page'  => 5,
			'post_type'       => array("post","page"),
			'post_status'     => 'publish',
			'orderby'         => 'menu_order',
			'order'           => "ASC",
			'meta_query' => array(
				array(
					'key' => 'is_summary',
					'value' => '1',
				)
			)
		);
	
		$the_query = new WP_Query( $args );
		if( $the_query->have_posts() ):
			while ( $the_query->have_posts() ): $the_query->the_post();
				$post_ = $the_query->post;
				$thumbnail_id = get_post_thumbnail_id($the_query->post->ID);
				$image = wp_get_attachment_image_src( $thumbnail_id, 'full' );
				$src = $image[0];
				$html = ""; //一旦初期化
				$html.='<img src="'.$src.'">';
				$html.='<a class="description" href="'.get_permalink().'">';
				$html.='	<h2>'.$post_->post_title.'</h2>';
				$html.='	<h3>'.get_post_meta($post_->ID,'まとめ英語タイトル',true).'</h3>';
				$html.='	<aside>'.get_post_meta($post_->ID,'まとめ日本語タイトル',true).'</aside>';
				$html.='</a>';
				$slides[] = $html;
			endwhile;
		endif;
		wp_reset_postdata();
	?>
	<section class="blog clear summary gray">
		<div class="content summary">
			<?php if(count($slides) > 0){ ?>
			<div class="sliders">
				<div class="swiper-container">
					<div class="swiper-wrapper">
					<?php foreach($slides as $slide){ ?>
						<div class="swiper-slide">
							<?php echo $slide; ?>
						</div>
					<?php } ?>
					</div>
				</div>
				<div class="swiper-button-next swiper-button-black"></div>
				<div class="swiper-button-prev swiper-button-black"></div>
				<div class="swiper-pagination swiper-pagination-black"></div>
			</div>

			<script>
				jQuery(function(){ 
					var swiper = new Swiper(".swiper-container", { 
						loop: true, 
						slidesPerView: 2,
						spaceBetween: 30,
						navigation: {
							nextEl: ".swiper-button-next",
							prevEl: ".swiper-button-prev",
						},
						pagination: {
							el: ".swiper-pagination", 
							clickable: true,
						},
						breakpoints: {
						320: {
							slidesPerView: 1,
							spaceBetween: 20
						},
						480: {
							slidesPerView: 1,
							spaceBetween: 30
						},
						640: {
							slidesPerView: 2,
							spaceBetween: 40
						}
					}
					}); 
				});
			</script>

			</div>
			<?php } ?>
			<p><?php the_content(); ?></p>			
		</div>


		<ul class="summary_posts">
		<?php
			$product_gender = get_post_meta($post->ID,'summary_gender',true);
			if(!$product_gender){
				$product_gender = "men"; //デフォルトはmen
			}
			$args = array(
				'number_posts'    => 5,
				'posts_per_page'  => 5,
				'post_type'       => array("post","page"),
				'post_status'     => 'publish',
				'orderby'         => 'menu_order',
				'order'           => "ASC",
				'tax_query' => array(
					array(
						'taxonomy' => 'category',
						'field'    => 'slug',
						'terms'    => 'how-to-select-'.$product_gender,
					),
				),
				'meta_query' => array(
					array(
						'key' => 'is_summary',
						'value' => '1',
					)
				)
			);

			$the_query = new WP_Query( $args );
			if( $the_query->have_posts() ):
				while ( $the_query->have_posts() ): $the_query->the_post();
					$post_ = $the_query->post;
					$thumbnail_id = get_post_thumbnail_id($the_query->post->ID);
					$image = wp_get_attachment_image_src( $thumbnail_id, 'full' );
					$src = $image[0];
					echo '<li>';
					echo '<a href="'.get_permalink().'">'; 
					echo '<div class="thumbnail"><img src="'.$src.'"></div>';
					echo '<div class="description" href="'.get_permalink().'">';
					echo '	<h2>'.$post_->post_title.'</h2>';
					echo '	<h3>'.get_post_meta($post_->ID,'まとめ英語タイトル',true).'</h3>';
					echo '	<aside>'.get_post_meta($post_->ID,'まとめ日本語タイトル',true).'</aside>';
					echo '</div></a>';
					echo '</li>';
				endwhile;
			endif;
			wp_reset_postdata();
			?>
		</ul>


	</section>
<?php endwhile; endif; ?>
	

<?php include 'brand-big-banner.php'; ?>
<?php get_footer(); ?>