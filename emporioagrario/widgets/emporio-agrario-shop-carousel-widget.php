<?php

class Emporio_Agrario_Shop_Carousel_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'emporio_agrario_shop_carousel_widget';
    }

    public function get_title() {
        return 'Emporio Agrario Shop - Carousel Widget';
    }

    public function get_icon() {
        // Icon here
        return 'eicon-slider-3d';
    }

    public function get_categories() {
        return [ 'general' ];
    }

    protected function _register_controls() {
        // Add controls here
    }

    protected function render() {
        
$apiUrl = EMPORIO_AGRARIO_MAGENTO2_API_URL . "products";
$accessToken = EMPORIO_AGRARIO_MAGENTO2_API_TOKEN;
$html = '';
//$jsonData = json_encode(["id" => {}]); // Replace with your actual data

// Set up search criteria
$searchCriteria = [
    'searchCriteria[filter_groups][0][filters][0][field]' => 'name',
    'searchCriteria[filter_groups][0][filters][0][value]' => '%25', // Wildcard for any name
    'searchCriteria[filter_groups][0][filters][0][condition_type]' => 'like'
];

// Build query string from the search criteria array
$queryString = http_build_query($searchCriteria);

// Append query string to the API URL
$fullApiUrl = $apiUrl . "?" . $queryString;

// Initialize cURL session
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $fullApiUrl);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer " . $accessToken
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute cURL session and close it
$response = curl_exec($ch);
curl_close($ch);

// Check for cURL errors
if ($response === false) {
    die('Error: "' . curl_error($ch) . '" - Code: ' . curl_errno($ch));
}

// Decode JSON response
$responseData = json_decode($response, true);


//var_dump($responseData);

$html = '<div class="elementor-swiper"><div class="elementor-main-swiper emporio-agrario-shop-products-carousel">
    <div class="swiper-wrapper">';
        foreach ($responseData['items'] as $item): 
            // Construct the URL to the product page
            $productUrl = "https://shop.emporioagrario.it/" . $item['custom_attributes'][4]['value'] . ".html";
            //$shortDescription = $item['custom_attributes'][2]['value']; // Assuming this is the short description
            
 
            $html .= '<div class="swiper-slide product-slide">';
            $html .= '<div class="product-img-wrapper">';
            $html .= '<img src="https://shop.emporioagrario.it/pub/media/catalog/product' . $item['custom_attributes'][3]['value'] . '" class="product-img" alt="' .  $item['name'] . '">';
            $html .= '</div>';
            $html .= '<div class="product-name">';
            $html .= '<a href="' . $productUrl . '" class="stretched-link" target="_blank" title="' . $item['name'] . '">' . $item['name'] . '</div>';
            $html .= '</a>';
            
            //$html .= '<div class="price">€ ' . number_format($item['price'], 2, ',', '.') . '</div>';
           // $html .= '<div>' . $shortDescription . '</div>';
            $html .= '<a href="' . $productUrl . '" class="stretched-link" target="_blank" title="' . $item['name'] . '">';
            $html .= '</a>';
            $html .= '</div>';
        endforeach;
    $html .= '</div>
    <!-- Add Pagination -->
    <div class="swiper-pagination"></div>
    <!-- Add Navigation -->
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>
</div></div>';
//echo ' OK';
echo $html;
//echo $html;

?>

 

<?php 
    }

    protected function _content_template() {
        ?>
       
        <?php
    }
}
