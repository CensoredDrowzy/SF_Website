<?php
require 'admin/api_helper.php';
?>
<script type="module" src="https://public.sellhub.cx/embeds.js"></script>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<?php

// Get products from API
$products = getSellHubProducts();

// Display products in cyberpunk style cards
foreach ($products as $product): 
    // Safely handle product data
    $productName = is_array($product['name'] ?? null) ? 'Product' : ($product['name'] ?? 'Product');
    $statusClass = strtolower($product['status'] ?? 'undetected');
    $statusColor = [
        'undetected' => 'text-green-400',
        'updated' => 'text-yellow-400', 
        'detected' => 'text-red-400'
    ][$statusClass] ?? 'text-gray-400';
?>
<div class="cyber-card p-6">
    <h3 class="text-2xl font-bold mb-6"><?= htmlspecialchars($productName) ?></h3>
    
    <div class="mb-4">
        <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold <?= $statusColor ?> border <?= $statusColor ?> border-opacity-50 mb-4">
            <span class="w-2 h-2 rounded-full <?= $statusColor ?> mr-2"></span>
            <?= strtoupper($product['status'] ?? 'UNDETECTED') ?>
        </div>
        
        <?php if (!empty($product['description']) && !is_array($product['description'])): 
            $features = array_filter(explode("\n", $product['description']));
            $isLongDescription = count($features) > 3 || max(array_map('strlen', $features)) > 100;
        ?>
        <h4 class="text-xs font-bold text-cyan-300 mb-2 tracking-wider">PRODUCT FEATURES</h4>
        <div class="bg-gradient-to-r from-cyan-500/10 to-purple-500/10 p-4 rounded-lg">
            <ul class="space-y-2" id="features-<?= htmlspecialchars($product['id'] ?? '') ?>">
                <?php foreach (array_slice($features, 0, 3) as $feature): ?>
                    <li class="flex items-start">
                        <svg class="w-4 h-4 mt-1 mr-2 text-cyan-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-sm text-cyan-100"><?= htmlspecialchars(trim($feature)) ?></span>
                    </li>
                <?php endforeach; ?>
                <?php if ($isLongDescription): ?>
                    <div x-data="{ expanded: false }">
                        <template x-if="!expanded">
                            <button @click="expanded = true" class="text-xs text-cyan-300 hover:text-white mt-2 flex items-center">
                                Show more features <i class="fas fa-chevron-down ml-1"></i>
                            </button>
                        </template>
                        <div x-show="expanded" x-collapse>
                            <?php foreach (array_slice($features, 3) as $feature): ?>
                                <li class="flex items-start">
                                    <svg class="w-4 h-4 mt-1 mr-2 text-cyan-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-sm text-cyan-100"><?= htmlspecialchars(trim($feature)) ?></span>
                                </li>
                            <?php endforeach; ?>
                        </div>
                        <template x-if="expanded">
                            <button @click="expanded = false" class="text-xs text-cyan-300 hover:text-white mt-2 flex items-center">
                                Show less <i class="fas fa-chevron-up ml-1"></i>
                            </button>
                        </template>
                    </div>
                <?php endif; ?>
            </ul>
        </div>
        <?php endif; ?>
    </div>
    
    <div class="mt-4">
        <button
            data-sellhub-product="<?= htmlspecialchars($product['id'] ?? '') ?>"
            class="px-8 py-3 text-black font-bold text-lg w-full rounded-full"
            style="
                background: linear-gradient(90deg, #00f0ff, #7b2dff);
                transition: all 0.3s ease;
                box-shadow: 0 4px 15px rgba(0, 240, 255, 0.3);
            "
            onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 10px 20px rgba(0, 240, 255, 0.3)'"
            onmouseout="this.style.transform='';this.style.boxShadow=''"
        >
            BUY NOW <i class="fas fa-arrow-right ml-2"></i>
        </button>
    </div>
</div>
<?php endforeach; ?>

<?php if (empty($products)): ?>
<div class="col-span-3 text-center py-10">
    <i class="fas fa-exclamation-triangle text-yellow-400 text-4xl mb-4"></i>
    <h3 class="text-xl font-bold text-cyan-300">No products available</h3>
    <p class="text-cyan-100">Please check back later or contact support</p>
</div>
<?php endif; ?>
