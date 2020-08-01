<?php 
$postid=get_the_ID();
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="team-list-content">
		<div class="post-content-image">
			<?php if(empty($disable_link) && $disable_link!='yes'){ ?>
				<a href="<?php echo esc_url($member_url); ?>">
			<?php } ?>
				<?php include THEPLUS_INCLUDES_URL. 'team-member/format-image.php'; ?>
			<?php if(empty($disable_link) && $disable_link!='yes'){ ?>
				</a>
			<?php } ?>
			<?php if(!empty($team_social_contnet) && !empty($display_social_icon) && $display_social_icon=='yes'){
				echo $team_social_contnet;
			} ?>
		</div>		
		<div class="post-content-bottom">			
			<?php include THEPLUS_INCLUDES_URL. 'team-member/post-meta-title.php'; ?>			
			<?php if(!empty($designation) && !empty($display_designation) && $display_designation=='yes'){
				echo $designation;
			} ?>
		</div>
		
	</div>
</article>
