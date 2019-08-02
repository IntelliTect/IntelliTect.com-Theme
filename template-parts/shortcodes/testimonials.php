
<?php

$posts = get_posts(array(
	"post_type" => "cpt_testimonials",
	"post_status" => "publish",
	"posts_per_page" => $count
));

$jsonData = array();

foreach ($posts as $post) {
	$jsonData[] = array(
		"id" => $post->ID,
		"content" => $post->post_content,
		"title" => $post->post_title,
		"imageUrl" => get_the_post_thumbnail_url($post->ID, "full"),
		"subtitle" => get_post_meta($post->ID, "subtitle", true)
	);
}

// Prepended with string because vue doesn't like IDs that start with a number.
$elementId = "sc_" . bin2hex(openssl_random_pseudo_bytes(8));

?>

<script type="text/x-template" id="testimonial-component">
	<div class="testimonial">

		<div class="testimonial-image">
			<img :src="testimonial.imageUrl"  >
		</div>
		<div class="testimonial-content" v-html="testimonial.content"></div>
		<div class="testimonial-title">{{testimonial.title}}</div>
		<div class="testimonial-subtitle">{{testimonial.subtitle}}</div>
	</div>
</script>

<div id="<?= $elementId ?>" class="testimonials" :style="{minHeight: minHeight + 'px'}" >
	<testimonial-component
		v-for="testimonial in testimonials"
		:key="'placeholder-' + testimonial.id "
		ref="placeholder"
		class="testimonial testimonial-height-ruler"
		:testimonial="testimonial">
	</testimonial-component>

	<transition name="fade" mode="out-in">
		<testimonial-component
			:style="{minHeight: minHeight + 'px'}"
			:key="current.id" :testimonial="current">
		</testimonial-component>
	</transition>

	<div class="dots">
		<div
			v-for="(testimonial, index) in testimonials"
			:key="'dot-' + testimonial.id "
			:title="testimonial.title"
			class="dot" :class="{active: testimonial.id == current.id }"
			@click="scrollTo(index)"
		>
		</div>
	</div>
</div>
<script>
	document.addEventListener("DOMContentLoaded", function(event) {
		Vue.component('testimonial-component', {
			template: '#testimonial-component',
			props: {
				testimonial: Object,
			}
		});
		new Vue({
			el: '#<?= $elementId ?>',
			data: {
				scrollTimeout: 0,
				currentIndex: 0,
				minHeight: 100,
				testimonials: <?= wp_json_encode($jsonData) ?>,
			},
			computed: {
				current() {
					return this.testimonials[this.currentIndex];
				},
			},
			methods: {
				scrollTo(index) {
					this.currentIndex = index;
					this.enqueueScroll();
				},
				adjustHeight() {
					this.minHeight = this.$refs.placeholder
						.map(function(p) { return p.$el.clientHeight })
						.reduce(function(prev, cur) { return Math.max(prev, cur)}, 0);
				},
				scrollNext() {
					this.currentIndex = (this.currentIndex + 1) % this.testimonials.length;
					this.enqueueScroll();
				},
				enqueueScroll() {
					clearTimeout(this.scrollTimeout);
					// Measure the amount of text in the next item.
					var placeholder = this.$refs.placeholder[this.currentIndex].$el;
					var content = placeholder.innerText;
					var wordCount = content.trim().split(/\s+/).length;

					// This is a little low for an average person,
					// but the content is more than just straight prose.
					// We also add a slight amount to the word count
					// to add a little bit of minimum hang time.
					var WPM = 200; // words per minute to scroll through.
					var duration = (wordCount + 3) / WPM * 60 * 1000;
					this.scrollTimeout = setTimeout(this.scrollNext.bind(this), duration);
				}
			},
			mounted() {
				this.enqueueScroll();
				this.$nextTick(this.adjustHeight);
				setInterval(this.adjustHeight.bind(this), 300);
			}
		})
	});
</script>
