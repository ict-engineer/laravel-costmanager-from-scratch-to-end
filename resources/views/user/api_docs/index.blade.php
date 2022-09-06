<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('imgs/favicon_io/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('imgs/favicon_io/android-chrome-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="512x512" href="{{ asset('imgs/favicon_io/android-chrome-512x512.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('imgs/favicon_io/favicon-16x16.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('imgs/favicon_io/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="48x48" href="{{ asset('imgs/favicon_io/favicon.png') }}">

    <link rel="stylesheet" href="{{ asset('api-docs/css/hightlightjs-dark.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.8.0/highlight.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,500|Source+Code+Pro:300" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('api-docs/css/style.css') }}" media="all">
    <script>hljs.initHighlightingOnLoad();</script>
</head>

<body>
<div class="left-menu">
    <div class="content-logo">
        <a href="/"><img alt="Logo" src="{{ asset('imgs/TheQuoteBox_logo.png') }}"/></a>
    </div>
    <div class="content-menu">
        <ul>
            <li class="scroll-to-link active" data-target="get-started">
                <a>GET STARTED</a>
            </li>
            <li class="scroll-to-link" data-target="getShop">
                <a>Get Shop Info</a>
            </li>
            <li class="scroll-to-link" data-target="addShop">
                <a>Add Shop</a>
            </li>
            <li class="scroll-to-link" data-target="editShop">
                <a>Edit Shop</a>
            </li>
            <li class="scroll-to-link" data-target="deleteShop">
                <a>Delete Shop</a>
            </li>
            <li class="scroll-to-link" data-target="getMaterial">
                <a>Get Material Info</a>
            </li>
            <li class="scroll-to-link" data-target="addMaterial">
                <a>Add Material</a>
            </li>
            <li class="scroll-to-link" data-target="editMaterial">
                <a>Edit Material</a>
            </li>
            <li class="scroll-to-link" data-target="deleteMaterial">
                <a>Delete Material</a>
            </li>
            <li class="scroll-to-link" data-target="errors">
                <a>Errors</a>
            </li>
        </ul>
    </div>
</div>
<div class="content-page">
    <div class="content-code"></div>
    <div class="content">
        <div class="overflow-hidden content-section" id="content-get-started">
            <h1 id="get-started">Get started</h1>
            <pre>
    API Endpoint

        https://www.thequotebox.app/api/
                </pre>
            <p>
                TheQuoteBox.app provides apis which let you get, add, edit and delete your shops and materials.
            </p>
            <p>
                To use this API, you need an <strong>API key</strong>. Please visit api tab at <a href="/user/profile">https://www.thequotebox.app/user/profile/</a> to get your own API key.
            </p>
        </div>
        <div class="overflow-hidden content-section" id="content-getShop">
            <h2 id="getShop">get shop info</h2>
            <pre><code class="bash">
# Here is a curl example
curl \
-X POST http://www.thequotebox.app/api/get-shop \
-F 'token=your_api_key' \
-F 'shop_name=Nastygal' \
                </code></pre>
            <p>
                To get shop info you need to make a POST call to the following url :<br>
                <code class="higlighted">http://www.thequotebox.app/api/get-shop</code>
            </p>
            <br>
            <pre><code class="json">
Result example :

{
    "shop_id": 10,
    "shop_name": "Nastygal",
    "address_line": "Douning Street, London",
    "country": "United Kingdom",
    "postal_code": "123123",
    "currency": "USD"
}
                </code></pre>
            <h4>QUERY PARAMETERS</h4>
            <table>
                <thead>
                <tr>
                    <th>Field</th>
                    <th>Type</th>
                    <th>Description</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>token</td>
                    <td>String</td>
                    <td>Your API key.</td>
                </tr>
                <tr>
                    <td>shop_name</td>
                    <td>String</td>
                    <td>Shop name to search.</td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="overflow-hidden content-section" id="content-addShop">
            <h2 id="addShop">add shop info</h2>
            <pre><code class="bash">
# Here is a curl example
curl \
-X POST http://www.thequotebox.app/api/add-shop \
-F 'token=your_api_key' \
-F 'shop_name=Nastygal' \
-F 'address_line=Douning Street, London' \
-F 'country=United Kindom' \
-F 'postal_code=300001' \
-F 'currency=USD' \

                </code></pre>
            <p>
                To add shop info you need to make a POST call to the following url :<br>
                <code class="higlighted">http://www.thequotebox.app/api/add-shop</code>
            </p>
            <br>
            <pre><code class="json">
Result example :

{
    "shop_id": 10,
    "shop_name": "Nastygal",
    "address_line": "Douning Street, London",
    "country": "United Kingdom",
    "postal_code": "123123",
    "currency": "USD"
}
                </code></pre>
            <h4>QUERY PARAMETERS</h4>
            <table>
                <thead>
                <tr>
                    <th>Field</th>
                    <th>Type</th>
                    <th>Description</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>token</td>
                    <td>String</td>
                    <td>Your API key.</td>
                </tr>
                <tr>
                    <td>shop_name</td>
                    <td>String</td>
                    <td>Shop name to search.</td>
                </tr>
                <tr>
                    <td>address_line</td>
                    <td>String</td>
                    <td>Address Line of shop.</td>
                </tr>
                <tr>
                    <td>country</td>
                    <td>String</td>
                    <td>Country of shop(English Name. Ex: Mexico).</td>
                </tr>
                <tr>
                    <td>postal_code</td>
                    <td>String</td>
                    <td>Postal code of shop address.</td>
                </tr>
                <tr>
                    <td>currency</td>
                    <td>String</td>
                    <td>Currency of shop.</td>
                </tr>
                </tbody>
            </table>
        </div>
        
        <div class="overflow-hidden content-section" id="content-editShop">
            <h2 id="editShop">edit shop info</h2>
            <pre><code class="bash">
# Here is a curl example
curl \
-X POST http://www.thequotebox.app/api/edit-shop \
-F 'token=your_api_key' \
-F 'shop_name=Nastygal' \
-F 'address_line=Douning Street, London' \
-F 'country=United Kindom' \
-F 'postal_code=300001' \
-F 'currency=USD' \
-F 'shop_id=10' \

                </code></pre>
            <p>
                To edit shop info you need to make a POST call to the following url :<br>
                <code class="higlighted">http://www.thequotebox.app/api/edit-shop</code>
            </p>
            <br>
            <pre><code class="json">
Result example :

{
    "shop_id": 10,
    "shop_name": "Nastygal",
    "address_line": "Douning Street, London",
    "country": "United Kingdom",
    "postal_code": "123123",
    "currency": "USD"
}
                </code></pre>
            <h4>QUERY PARAMETERS</h4>
            <table>
                <thead>
                <tr>
                    <th>Field</th>
                    <th>Type</th>
                    <th>Description</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>token</td>
                    <td>String</td>
                    <td>Your API key.</td>
                </tr>
                <tr>
                    <td>shop_name</td>
                    <td>String</td>
                    <td>Shop name to search.</td>
                </tr>
                <tr>
                    <td>address_line</td>
                    <td>String</td>
                    <td>Address Line of shop.</td>
                </tr>
                <tr>
                    <td>country</td>
                    <td>String</td>
                    <td>Country of shop(English Name. Ex: Mexico).</td>
                </tr>
                <tr>
                    <td>postal_code</td>
                    <td>String</td>
                    <td>Postal code of shop address.</td>
                </tr>
                <tr>
                    <td>currency</td>
                    <td>String</td>
                    <td>Currency of shop.</td>
                </tr>
                <tr>
                    <td>shop_id</td>
                    <td>BigInteger</td>
                    <td>Shop id to edit.</td>
                </tr>
                </tbody>
            </table>
        </div>
        
        <div class="overflow-hidden content-section" id="content-deleteShop">
            <h2 id="deleteShop">delete shop info</h2>
            <pre><code class="bash">
# Here is a curl example
curl \
-X POST http://www.thequotebox.app/api/delete-shop \
-F 'token=your_api_key' \
-F 'shop_id=10' \

                </code></pre>
            <p>
                To delete shop info you need to make a POST call to the following url :<br>
                <code class="higlighted">http://www.thequotebox.app/api/delete-shop</code>
            </p>
            <br>
            <pre><code class="json">
Result example :

{
    "success": "Deleted Successfully"
}
                </code></pre>
            <h4>QUERY PARAMETERS</h4>
            <table>
                <thead>
                <tr>
                    <th>Field</th>
                    <th>Type</th>
                    <th>Description</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>token</td>
                    <td>String</td>
                    <td>Your API key.</td>
                </tr>
                <tr>
                    <td>shop_id</td>
                    <td>BigInteger</td>
                    <td>Shop id to delete.</td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="overflow-hidden content-section" id="content-getMaterial">
            <h2 id="getMaterial">get material info</h2>
            <pre><code class="bash">
# Here is a curl example
curl \
-X POST http://www.thequotebox.app/api/get-material \
-F 'token=your_api_key' \
-F 'shop_id=10' \
-F 'sku=A3000001' \

                </code></pre>
            <p>
                To get material info you need to make a POST call to the following url :<br>
                <code class="higlighted">http://www.thequotebox.app/api/get-material</code>
            </p>
            <br>
            <pre><code class="json">
Result example :

{
    "material_id": 90982,
    "description": "Brush",
    "brand": "BO",
    "sku": "A300001",
    "part_no": "ESA_123",
    "price": "123",
    "image": "https://www.thequotebox.app/1.png",
    "shop": {
        "shop_id": 9,
        "shop_name": "NastyGal",
        "address_line": "London",
        "country": "United Kingdom",
        "postal_code": "123123",
        "currency": "USD"
    }
}
                </code></pre>
            <h4>QUERY PARAMETERS</h4>
            <table>
                <thead>
                <tr>
                    <th>Field</th>
                    <th>Type</th>
                    <th>Description</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>token</td>
                    <td>String</td>
                    <td>Your API key.</td>
                </tr>
                <tr>
                    <td>shop_id</td>
                    <td>BigInteger</td>
                    <td>Shop id which contains material.</td>
                </tr>
                <tr>
                    <td>sku</td>
                    <td>String</td>
                    <td>Material SKU.</td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="overflow-hidden content-section" id="content-addMaterial">
            <h2 id="addMaterial">add material info</h2>
            <pre><code class="bash">
# Here is a curl example
curl \
-X POST http://www.thequotebox.app/api/add-material \
-F 'token=your_api_key' \
-F 'description=Brush' \
-F 'brand=BO' \
-F 'sku=A300001' \
-F 'part_no=ESA_123' \
-F 'price=121' \
-F 'shop_id=10' \
-F 'image=https://www.thequotebox.app/1.png' \

                </code></pre>
            <p>
                To add material info you need to make a POST call to the following url :<br>
                <code class="higlighted">http://www.thequotebox.app/api/add-material</code>
            </p>
            <br>
            <pre><code class="json">
Result example :

{
    "material_id": 90982,
    "description": "Brush",
    "brand": "BO",
    "sku": "A300001",
    "part_no": "ESA_123",
    "price": "123",
    "image": "https://www.thequotebox.app/1.png",
    "shop": {
        "shop_id": 9,
        "shop_name": "NastyGal",
        "address_line": "London",
        "country": "United Kingdom",
        "postal_code": "123123",
        "currency": "USD"
    }
}
                </code></pre>
            <h4>QUERY PARAMETERS</h4>
            <table>
                <thead>
                <tr>
                    <th>Field</th>
                    <th>Type</th>
                    <th>Description</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>token</td>
                    <td>String</td>
                    <td>Your API key.</td>
                </tr>
                <tr>
                    <td>description</td>
                    <td>String</td>
                    <td>Material Description.</td>
                </tr>
                <tr>
                    <td>brand</td>
                    <td>String</td>
                    <td>Material Brand(Nullable).</td>
                </tr>
                <tr>
                    <td>sku</td>
                    <td>String</td>
                    <td>Material SKU(Unique in same shop).</td>
                </tr>
                <tr>
                    <td>part_no</td>
                    <td>String</td>
                    <td>Material Part No.</td>
                </tr>
                <tr>
                    <td>price</td>
                    <td>Double</td>
                    <td>Material Price.</td>
                </tr>
                <tr>
                    <td>image</td>
                    <td>String</td>
                    <td>Material Image Url.</td>
                </tr>
                <tr>
                    <td>shop_id</td>
                    <td>BigInteger</td>
                    <td>Shop id to add Material.</td>
                </tr>
                </tbody>
            </table>
        </div>
        
        <div class="overflow-hidden content-section" id="content-editMaterial">
            <h2 id="editMaterial">edit material info</h2>
            <pre><code class="bash">
# Here is a curl example
curl \
-X POST http://www.thequotebox.app/api/edit-material \
-F 'token=your_api_key' \
-F 'description=Brush' \
-F 'brand=BO' \
-F 'sku=A300001' \
-F 'part_no=ESA_123' \
-F 'price=121' \
-F 'material_id=100001' \
-F 'image=https://www.thequotebox.app/1.png' \

                </code></pre>
            <p>
                To edit material info you need to make a POST call to the following url :<br>
                <code class="higlighted">http://www.thequotebox.app/api/edit-material</code>
            </p>
            <br>
            <pre><code class="json">
Result example :

{
    "material_id": 90982,
    "description": "Brush",
    "brand": "BO",
    "sku": "A300001",
    "part_no": "ESA_123",
    "price": "123",
    "image": "https://www.thequotebox.app/1.png",
    "shop": {
        "shop_id": 9,
        "shop_name": "NastyGal",
        "address_line": "London",
        "country": "United Kingdom",
        "postal_code": "123123",
        "currency": "USD"
    }
}
                </code></pre>
            <h4>QUERY PARAMETERS</h4>
            <table>
                <thead>
                <tr>
                    <th>Field</th>
                    <th>Type</th>
                    <th>Description</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>token</td>
                    <td>String</td>
                    <td>Your API key.</td>
                </tr>
                <tr>
                    <td>description</td>
                    <td>String</td>
                    <td>Material Description.</td>
                </tr>
                <tr>
                    <td>brand</td>
                    <td>String</td>
                    <td>Material Brand(Nullable).</td>
                </tr>
                <tr>
                    <td>sku</td>
                    <td>String</td>
                    <td>Material SKU(Unique in same shop).</td>
                </tr>
                <tr>
                    <td>part_no</td>
                    <td>String</td>
                    <td>Material Part No.</td>
                </tr>
                <tr>
                    <td>price</td>
                    <td>Double</td>
                    <td>Material Price.</td>
                </tr>
                <tr>
                    <td>image</td>
                    <td>String</td>
                    <td>Material Image Url.</td>
                </tr>
                <tr>
                    <td>material_id</td>
                    <td>BigInteger</td>
                    <td>Material id to edit.</td>
                </tr>
                </tbody>
            </table>
        </div>
        
        <div class="overflow-hidden content-section" id="content-deleteMaterial">
            <h2 id="deleteMaterial">delete material info</h2>
            <pre><code class="bash">
# Here is a curl example
curl \
-X POST http://www.thequotebox.app/api/get-material \
-F 'token=your_api_key' \
-F 'material_id=10001' \

                </code></pre>
            <p>
                To get material info you need to make a POST call to the following url :<br>
                <code class="higlighted">http://www.thequotebox.app/api/get-material</code>
            </p>
            <br>
            <pre><code class="json">
Result example :

{
    "success": "Deleted Successfully"
}
                </code></pre>
            <h4>QUERY PARAMETERS</h4>
            <table>
                <thead>
                <tr>
                    <th>Field</th>
                    <th>Type</th>
                    <th>Description</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>token</td>
                    <td>String</td>
                    <td>Your API key.</td>
                </tr>
                <tr>
                    <td>material_id</td>
                    <td>BigInteger</td>
                    <td>Material id to delete.</td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="overflow-hidden content-section" id="content-errors">
            <h2 id="errors">Errors</h2>
            <p>
                The Thequtebox.app API uses the following error:
            </p>
            <table>
                <thead>
                <tr>
                    <th>Error String</th>
                    <th>Meaning</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Invalid Token.</td>
                    <td>
                        Api Key on your request is not existed.
                    </td>
                </tr>
                <tr>
                    <td>Invalid Data.</td>
                    <td>
                        The data you reqested is wrong.
                    </td>
                </tr>
                <tr>
                    <td>No existing shop with this shop name.</td>
                    <td>
                        Can't find shop with name you requested.
                    </td>
                </tr>
                <tr>
                    <td>Can not delete others shop.</td>
                    <td>
                        Shop id you reqested is others shop.
                    </td>
                </tr>
                <tr>
                    <td>Can not edit others shop.</td>
                    <td>
                        Shop id you reqested is others shop.
                    </td>
                </tr>
                <tr>
                    <td>Can not add material to others shop.</td>
                    <td>
                        Shop id you reqested is others shop.
                    </td>
                </tr>
                <tr>
                    <td>Shop is not yours with this shop id.</td>
                    <td>
                        Shop id you reqested is others shop.
                    </td>
                </tr>
                <tr>
                    <td>No existing material with this shop id and sku.</td>
                    <td>
                        Can't find Material info with shop id and sku you requested.
                    </td>
                </tr>
                <tr>
                    <td>Can not delete material on others shop.</td>
                    <td>
                        Shop id you reqested is others shop.
                    </td>
                </tr>
                <tr>
                    <td>Can not edit material on others shop.</td>
                    <td>
                        Shop id you reqested is others shop.
                    </td>
                </tr>
                <tr>
                    <td>Invalid shop id.</td>
                    <td>
                        Shop id you reqested is others shop.
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="content-code"></div>
</div>
<!-- END Github Corner Ribbon - to remove -->
<script src="{{ asset('api-docs/js/script.js') }}"></script>
</body>
</html>