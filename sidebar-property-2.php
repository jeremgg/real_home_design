<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package _rhd
 */
?>

	<div id="third" class="content-sidebar col-xs-12 col-sm-4" role="complementary">
		<div class="well">
			<div class="taxonomy">
				<?php
				$args = array(

				    'post' => 0,  //default to current post
				    'sep' => ' ',
				    'template' => '<i class="fa fa-bookmark" aria-hidden="true"></i><p>In</p><p style="display:none;">%s:</p>  %l'
				);
				the_taxonomies( $args );
				?>

			</div>

			<div class="meta row">
				<div class="meta-title col-xs-3 col-sm-3">
					<p>client : </p>
					<p>date : </p>
					<p>info : </p>
				</div>

				<div class="meta-content col-xs-9 col-sm-9">
					<p><?php the_field('client'); ?></p>
					<?php $date_d = get_field('date');
	           // Extraire Y,M,D
	           $y = substr($date_d, 0, 10);
	           $m = substr($date_d, 4, 2);
	           $d = substr($date_d, 6, 2);

	           // Créer le format UNIX
	           $time_d = strtotime("{$d}-{$m}-{$y}");
	        ?>
					<p class="date"><?php echo date_i18n('l d F Y', $time_d); ?></p>
					<p><?php the_field('info'); ?></p>
				</div>
			</div>

			<div class="property-content">
				<?php the_content(); ?>
				<a href="#" class="btn btn-primary">buy this object</a>
			</div>
		</div>
	</div><!-- #secondary -->
