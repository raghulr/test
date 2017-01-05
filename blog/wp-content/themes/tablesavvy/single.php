<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
get_header();?>        
<div id="container">
    <div id="content" role="main">
        <?php if (have_posts()) while (have_posts()) : the_post(); ?>
                <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <div class="post-meta">                        <div class="post-title"><h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf(esc_attr__('Permalink to %s', 'twentyten'), the_title_attribute('echo=0')); ?>" rel="bookmark"><?php the_title(); ?></a></h2></div>
                       
                    </div>
                    <div class="entry-meta">
                        <?php twentyten_posted_on(); ?>
                    </div>
                    <!-- .entry-meta -->
                    <div class="entry-content">
                        <?php the_content(); ?>
                        <?php wp_link_pages(array('before' => '<div class="page-link">' . __('Pages:', 'twentyten'), 'after' => '</div>')); ?>
                    </div>
                    <!-- .entry-content -->
                    <?php if (get_the_author_meta('description')) : // If a user has filled out their description, show a bio on their entries  ?>
                        <div id="entry-author-info">
                            <div id="author-avatar">
                                <?php echo get_avatar(get_the_author_meta('user_email'), apply_filters('twentyten_author_bio_avatar_size', 60)); ?>
                            </div><!-- #author-avatar -->
                            <div id="author-description">
                                <h2><?php printf(esc_attr__('About %s', 'twentyten'), get_the_author()); ?></h2>
                                <?php the_author_meta('description'); ?>
                                <div id="author-link">
                                    <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>">
                                        <?php printf(__('View all posts by %s <span class="meta-nav">&rarr;</span>', 'twentyten'), get_the_author()); ?>
                                    </a>
                                </div><!-- #author-link	-->
                            </div><!-- #author-description -->
                        </div><!-- #entry-author-info -->
                    <?php endif; ?>
                    <div class="entry-utility">
                        <?php twentyten_posted_in(); ?>
                        <?php edit_post_link(__('Edit', 'twentyten'), '<span class="edit-link">', '</span>'); ?>
                    </div><!-- .entry-utility -->
                </div><!-- #post-## -->
                <div id="nav-below" class="navigation">
                    <div class="nav-previous"><?php next_posts_link(__('<span class="meta-nav"></span>Previous', 'twentyten')); ?></div>
                    <div class="nav-next"><?php previous_posts_link(__('Next<span class="meta-nav"></span>', 'twentyten')); ?></div>
                </div><!-- #nav-below -->
                <?php comments_template('', true); ?>
            <?php endwhile; // end of the loop. ?>
    </div><!-- #content -->
</div><!-- #container -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>