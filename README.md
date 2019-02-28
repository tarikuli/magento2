# Problem 1
#### What is the output of the following PHP code and explain why:
```
$a = '1';
$b = &$a;
$b = "2$b";
echo $a.", ".$b;
```
#### Soluation:
```
Output will be = 21,21
In Line number 1, set a variable value equal 1 (Passed by value)
In Line number 2,  PHP "Assign By Reference" create a new reference of variable $a by ampersand, Its means $a value not push in $b, $a memory location push in $d with value. $a and $b both using same memory location in RAM and same value. 
In Line number 3, 2 concate $b (value=1) equal 21 and push to varible $b (value = 21).
In Line number 4, print both variable value 21, 21 (because both reference use same memory location)
```

# Problem 2
#### Complete the following with PHP.
```
Consider a store where items have prices per unit but also volume prices. For example, apples may
be $1.00 each or 4 for $3.00.
Implement a point-of-sale scanning API that accepts an arbitrary ordering of products (similar to
what would happen at a checkout line) and then returns the correct total price for an entire
shopping cart based on the per unit prices or the volume prices as applicable.
Here are the products listed by code and the prices to use (there is no sales tax):
Product Code | Price
--------------------
A | $2.00 each or 4 for $7.00
B | $12.00
C | $1.25 or $6 for a six pack
D | $0.15
There should be a top level point of sale terminal service object that looks something like the
pseudo-code below.
You are free to
design and implement the rest of the code however you wish, including how you specify the prices
in the system:
terminal->setPricing(...)
terminal->scan("A")
terminal->scan("C")
... etc.
result = terminal->total
Here are the minimal inputs you should use for your test cases. These test cases must be shown to
work in your program:
Scan these items in this order: ABCDABAA; Verify the total price is $32.40.
Scan these items in this order: CCCCCCC; Verify the total price is $7.25.
Scan these items in this order: ABCD; Verify the total price is $15.40.
```
#### Soluation:
```
<?php

// Get skus from user 
// Ex: php cartTotalPrice.php ABCDABAA 
$inputSkus = str_split($argv[1], 1);

// Counts all the values of an array
$countSkuArray = array_count_values($inputSkus);
#print_r($counts);

// Set each product price and bundel pro
$products = [
    'A' => [
        '1' => 2.00,
        '4' => 7.00
    ],
    'B' => [
        '1' => 12.00
    ],
    'C' => [
        '1' => 1.25,
        '6' => 6.00
    ],
    'D' => [
        '1' => 0.15
    ]
];

// Final total price
$total = 0;

foreach ($countSkuArray as $cartSku => $price) {
    
    
    if (isset($products[$cartSku]) && count($products[$cartSku]) > 1) {
        
        $groupUnit = max(array_keys($products[$cartSku]));
        $subtotal = intval($price / $groupUnit) * $products[$cartSku][$groupUnit] + fmod($price, $groupUnit) * $products[$cartSku]['1'];
        
        $total += $subtotal;
        
    } elseif (isset($products[$cartSku])) {
        
        $subtotal = $price * $products[$cartSku]['1'];
        $total += $subtotal;
    }

    echo "\nSKU = " . $cartSku . " QTY = ".count($products[$cartSku]) . " Subtotal = $" . number_format($subtotal, 2);
}

echo "\nFinal Total: $" . number_format($total, 2)."\n";

?>
```

# Problem 3
#### Create a Magento2 module to allow the registered customers to download the csv for cart
1) products. This feature should be available in cart.
2) Admin should be able enable/disable this feature

#### Soluation:
I developed a custom Module for download cart items in csv file. Viwe detailes from here
https://github.com/tarikuli/magento2/tree/master/app/code/Jewel/CartCsv or Click [Download](http://image.mymonogramonline.com/Jewel.zip) link for Zip file.

<b>Front End Evidence</b>
<img class="float-left rounded-1" src="http://image.mymonogramonline.com/evidence.png" width="900" alt="Evidence">

<b>Admin Back End Evidence</b>
<img class="float-left rounded-1" src="http://image.mymonogramonline.com/admin_edvience.png" width="900" alt="Evidence">
