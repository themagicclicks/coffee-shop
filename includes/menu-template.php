<?php
$menuPdfSections = isset($menuPdfSections) && is_array($menuPdfSections) ? $menuPdfSections : [];
?>
<div id="menu-pdf-template" class="menu-pdf-source" aria-hidden="true">
    <div class="menu-pdf-page">
		<div class="menu-pdf-left">
			<img src="<?php echo SITE; ?>images/menu-border.png" alt="" class="menu-pdf-decor menu-pdf-decor--left">
		</div>
		<div class="menu-pdf-center">    
			
			<header class="menu-pdf-header">
				<img src="<?php echo SITE; ?>images/willow-cup-coffee-black.svg" alt="Willow Cup Coffee" class="menu-pdf-logo">
				<div class="menu-pdf-kicker">Classic Coffee Menu</div>
			   <!-- <h1>Willow Cup Coffee</h1>-->
				<p>Freshly brewed classics, house favourites, and all-day comfort.</p>
			</header>

			<main class="menu-pdf-body">
				<?php foreach ($menuPdfSections as $section) { ?>
					<section class="menu-pdf-section">
						<h2><?php echo htmlspecialchars((string) ($section['title'] ?? 'Menu')); ?></h2>
						<ul class="menu-pdf-items">
							<?php foreach (($section['items'] ?? []) as $item) { ?>
								<li class="menu-pdf-item">
									<div class="menu-pdf-item__main">
										<h3><?php echo htmlspecialchars((string) ($item['title'] ?? 'Menu Item')); ?></h3>
										<?php if (!empty($item['subtitle'])) { ?>
											<p><?php echo htmlspecialchars((string) $item['subtitle']); ?></p>
										<?php } ?>
									</div>
									<div class="menu-pdf-item__price">
										<?php echo htmlspecialchars((string) (($item['price'] ?? $item['Price'] ?? ''))); ?>
									</div>
								</li>
							<?php } ?>
						</ul>
					</section>
				<?php } ?>
			</main>

			<footer class="menu-pdf-footer">
				<div class="menu-pdf-footer__band">
					<img src="<?php echo SITE; ?>images/willow-cup-coffee-white.svg" alt="Willow Cup Coffee" class="menu-pdf-footer__logo">
					<span>www.willowcupcoffee.com</span>
				</div>
			</footer>
		</div>
		<div class="menu-pdf-right">
			<img src="<?php echo SITE; ?>images/menu-border.png" alt="" class="menu-pdf-decor menu-pdf-decor--right">
		</div>
    </div>
</div>
