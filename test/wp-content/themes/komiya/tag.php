<?php get_header(); ?>
<section>
    <section class="site_width_inner">
		<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
			<div><a href="<?php the_permalink(); ?>" ><?php the_post_thumbnail('thumbnail'); ?></a></div>
		<?php endwhile; ?>
		<?php else : ?>
			<p>お探しのページは見つかりません。</p>
		<?php endif; ?>
	</section>
</section>

<section>
	<div class="four_cubes">
		<ul>
			<li><a href="#"><div class="overlay"></div><img src="/wp-content/themes/komiya/img/crew-56835.jpg"></a></li>
			<li><a href="#"><div class="overlay"></div><img src="/wp-content/themes/komiya/img/eduard-militaru-196832.jpg"></a></li>
			<li><a href="#"><div class="overlay"></div><img src="/wp-content/themes/komiya/img/jonathan-velasquez-1187.jpg"></a></li>
			<li><a href="#"><div class="overlay"></div><img src="/wp-content/themes/komiya/img/kari-shea-272383.jpg"></a></li>
			<li><a href="#"><div class="overlay"></div><img src="/wp-content/themes/komiya/img/khai-sze-ong-308080.jpg"></a></li>
			<li><a href="#"><div class="overlay"></div><img src="/wp-content/themes/komiya/img/pineapple-supply-co-142104.jpg"></a></li>
			<li><a href="#"><div class="overlay"></div><img src="/wp-content/themes/komiya/img/william-iven-5893.jpg"></a></li>
			<li><a href="#"><div class="overlay"></div><img src="/wp-content/themes/komiya/img/crew-56835.jpg"></a></li>
		</ul>
	</div>
</section>
<section>
    <section class="site_width_inner">
    	<div class="backtotop"><a href="#backtotop">Back to top</a></div>
    </section>
</section>
<?php include 'brand-big-banner.php'; ?>
<?php get_footer(); ?>