<?php
defined('C5_EXECUTE') or die("Access Denied.");
?>
<script type="text/javascript">
	$(function(){
		$('[id^=question]').click(function(){
			cnt = $(this).attr("value");
			$('#answer' + cnt).slideToggle(600);
			return false;
		});
	});
</script>

<?php 
$rssUrl = $showRss ? $controller->getRssUrl($b) : '';
$th = Loader::helper('text');
$ih = Loader::helper('image'); //<--uncomment this line if displaying image attributes (see below)
//Note that $nh (navigation helper) is already loaded for us by the controller (for legacy reasons)
?>

<div class="ccm-page-list-top-menu">

	<?php $loopcount=0 ?>
	<?php foreach ($pages as $page):
		$loopcount++;

		// Prepare data for each page being listed...
		$title = $th->entities($page->getCollectionName());
		$url = $nh->getLinkToCollection($page);
		$target = ($page->getCollectionPointerExternalLink() != '' && $page->openCollectionPointerExternalLinkInNewWindow()) ? '_blank' : $page->getAttribute('nav_target');
		$target = empty($target) ? '_self' : $target;
		$description = $page->getCollectionDescription();
		$description = $controller->truncateSummaries ? $th->shorten($description, $controller->truncateChars) : $description;
		$description = $th->entities($description);	
		$question = $page->getAttribute('q_a_question');
		$answer = $page->getAttribute('q_a_answer');
		
	?>

		<div class="q_and_a">
			<div class="question">
				<div class="q-image"></div>
				<div class="q-content">
					<?php
						$cp = new Permissions($page);
						if($cp->canViewToolbar()) { 
							$ct = CollectionType::getByID($page->getCollectionTypeID());
							if(is_object($ct)){
								if($ct->isCollectionTypeIncludedInComposer()){
									$editurl = $this->url('/dashboard/composer/write', 'edit', $page->getCollectionID());
								}else{
									$editurl = $url;
								}
							}else{
								$editurl = $url;
							}
						?>
									
						<a href="<?php echo $editurl ?>"><?php echo t('edit') ?></a>
					<?php } ?>

					<a id="question<?php echo $loopcount ?>" value ="<?php echo $loopcount ?>"  href="#">
						<h3><?php  echo $question; ?></h3>
					</a>
				</div>
			</div>
		
			<div class="q_a_border"></div>
		
			<div id="answer<?php echo $loopcount ?>" class="answer" style="display:none;">
				<div class="a-image"></div>
				<div class="a-content">
					<?php  echo $answer; ?>
				</div>
			</div>
		</div>
		<div class="q_a_specer"></div>
	<?php endforeach; ?>
</div>
