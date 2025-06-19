<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Laravel API Documentation</title>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset("/vendor/scribe/css/theme-default.style.css") }}" media="screen">
    <link rel="stylesheet" href="{{ asset("/vendor/scribe/css/theme-default.print.css") }}" media="print">

    <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.10/lodash.min.js"></script>

    <link rel="stylesheet"
          href="https://unpkg.com/@highlightjs/cdn-assets@11.6.0/styles/obsidian.min.css">
    <script src="https://unpkg.com/@highlightjs/cdn-assets@11.6.0/highlight.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jets/0.14.1/jets.min.js"></script>

    <style id="language-style">
        /* starts out as display none and is replaced with js later  */
                    body .content .bash-example code { display: none; }
                    body .content .javascript-example code { display: none; }
            </style>

    <script>
        var tryItOutBaseUrl = "http://rest-api.test";
        var useCsrf = Boolean();
        var csrfUrl = "/sanctum/csrf-cookie";
    </script>
    <script src="{{ asset("/vendor/scribe/js/tryitout-5.2.1.js") }}"></script>

    <script src="{{ asset("/vendor/scribe/js/theme-default-5.2.1.js") }}"></script>

</head>

<body data-languages="[&quot;bash&quot;,&quot;javascript&quot;]">

<a href="#" id="nav-button">
    <span>
        MENU
        <img src="{{ asset("/vendor/scribe/images/navbar.png") }}" alt="navbar-image"/>
    </span>
</a>
<div class="tocify-wrapper">
    
            <div class="lang-selector">
                                            <button type="button" class="lang-button" data-language-name="bash">bash</button>
                                            <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                    </div>
    
    <div class="search">
        <input type="text" class="search" id="input-search" placeholder="Search">
    </div>

    <div id="toc">
                    <ul id="tocify-header-introduction" class="tocify-header">
                <li class="tocify-item level-1" data-unique="introduction">
                    <a href="#introduction">Introduction</a>
                </li>
                            </ul>
                    <ul id="tocify-header-authenticating-requests" class="tocify-header">
                <li class="tocify-item level-1" data-unique="authenticating-requests">
                    <a href="#authenticating-requests">Authenticating requests</a>
                </li>
                            </ul>
                    <ul id="tocify-header-customer" class="tocify-header">
                <li class="tocify-item level-1" data-unique="customer">
                    <a href="#customer">Customer</a>
                </li>
                                    <ul id="tocify-subheader-customer" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="customer-create">
                                <a href="#customer-create">Create</a>
                            </li>
                                                            <ul id="tocify-subheader-customer-create" class="tocify-subheader">
                                                                            <li class="tocify-item level-3" data-unique="customer-POSTapi-customers">
                                            <a href="#customer-POSTapi-customers">POST api/customers</a>
                                        </li>
                                                                    </ul>
                                                                                <li class="tocify-item level-2" data-unique="customer-update">
                                <a href="#customer-update">Update</a>
                            </li>
                                                            <ul id="tocify-subheader-customer-update" class="tocify-subheader">
                                                                            <li class="tocify-item level-3" data-unique="customer-PUTapi-customers--id-">
                                            <a href="#customer-PUTapi-customers--id-">PUT api/customers/{id}</a>
                                        </li>
                                                                            <li class="tocify-item level-3" data-unique="customer-PATCHapi-customers--id-">
                                            <a href="#customer-PATCHapi-customers--id-">PATCH api/customers/{id}</a>
                                        </li>
                                                                    </ul>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-endpoints" class="tocify-header">
                <li class="tocify-item level-1" data-unique="endpoints">
                    <a href="#endpoints">Endpoints</a>
                </li>
                                    <ul id="tocify-subheader-endpoints" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="endpoints-GETapi-user">
                                <a href="#endpoints-GETapi-user">GET api/user</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-laporan-transaksi-bulanan" class="tocify-header">
                <li class="tocify-item level-1" data-unique="laporan-transaksi-bulanan">
                    <a href="#laporan-transaksi-bulanan">Laporan Transaksi Bulanan</a>
                </li>
                                    <ul id="tocify-subheader-laporan-transaksi-bulanan" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="laporan-transaksi-bulanan-ringkasan-transaksi-3-tahun-terakhir">
                                <a href="#laporan-transaksi-bulanan-ringkasan-transaksi-3-tahun-terakhir">Ringkasan Transaksi 3 Tahun Terakhir</a>
                            </li>
                                                            <ul id="tocify-subheader-laporan-transaksi-bulanan-ringkasan-transaksi-3-tahun-terakhir" class="tocify-subheader">
                                                                            <li class="tocify-item level-3" data-unique="laporan-transaksi-bulanan-GETapi-monthly-transactions">
                                            <a href="#laporan-transaksi-bulanan-GETapi-monthly-transactions">GET api/monthly-transactions</a>
                                        </li>
                                                                    </ul>
                                                                                <li class="tocify-item level-2" data-unique="laporan-transaksi-bulanan-target-revenue-dan-income-bulanan">
                                <a href="#laporan-transaksi-bulanan-target-revenue-dan-income-bulanan">Target, Revenue, dan Income Bulanan</a>
                            </li>
                                                            <ul id="tocify-subheader-laporan-transaksi-bulanan-target-revenue-dan-income-bulanan" class="tocify-subheader">
                                                                            <li class="tocify-item level-3" data-unique="laporan-transaksi-bulanan-GETapi-monthly-transactions-targets-and-transactions">
                                            <a href="#laporan-transaksi-bulanan-GETapi-monthly-transactions-targets-and-transactions">GET api/monthly-transactions/targets-and-transactions</a>
                                        </li>
                                                                    </ul>
                                                                                <li class="tocify-item level-2" data-unique="laporan-transaksi-bulanan-performa-sales-bulanan">
                                <a href="#laporan-transaksi-bulanan-performa-sales-bulanan">Performa Sales Bulanan</a>
                            </li>
                                                            <ul id="tocify-subheader-laporan-transaksi-bulanan-performa-sales-bulanan" class="tocify-subheader">
                                                                            <li class="tocify-item level-3" data-unique="laporan-transaksi-bulanan-GETapi-monthly-sales-performance">
                                            <a href="#laporan-transaksi-bulanan-GETapi-monthly-sales-performance">GET api/monthly-sales-performance</a>
                                        </li>
                                                                    </ul>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-sales-order" class="tocify-header">
                <li class="tocify-item level-1" data-unique="sales-order">
                    <a href="#sales-order">Sales Order</a>
                </li>
                                    <ul id="tocify-subheader-sales-order" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="sales-order-create">
                                <a href="#sales-order-create">Create</a>
                            </li>
                                                            <ul id="tocify-subheader-sales-order-create" class="tocify-subheader">
                                                                            <li class="tocify-item level-3" data-unique="sales-order-POSTapi-sales-orders">
                                            <a href="#sales-order-POSTapi-sales-orders">POST api/sales-orders</a>
                                        </li>
                                                                    </ul>
                                                                        </ul>
                            </ul>
            </div>

    <ul class="toc-footer" id="toc-footer">
                    <li style="padding-bottom: 5px;"><a href="{{ route("scribe.postman") }}">View Postman collection</a></li>
                            <li style="padding-bottom: 5px;"><a href="{{ route("scribe.openapi") }}">View OpenAPI spec</a></li>
                <li><a href="http://github.com/knuckleswtf/scribe">Documentation powered by Scribe ✍</a></li>
    </ul>

    <ul class="toc-footer" id="last-updated">
        <li>Last updated: June 19, 2025</li>
    </ul>
</div>

<div class="page-wrapper">
    <div class="dark-box"></div>
    <div class="content">
        <h1 id="introduction">Introduction</h1>
<aside>
    <strong>Base URL</strong>: <code>http://rest-api.test</code>
</aside>
<pre><code>This documentation aims to provide all the information you need to work with our API.

&lt;aside&gt;As you scroll, you'll see code examples for working with the API in different programming languages in the dark area to the right (or as part of the content on mobile).
You can switch the language used with the tabs at the top right (or from the nav menu at the top left on mobile).&lt;/aside&gt;</code></pre>

        <h1 id="authenticating-requests">Authenticating requests</h1>
<p>This API is not authenticated.</p>

        <h1 id="customer">Customer</h1>

    

                        <h2 id="customer-create">Create</h2>
                                        <p>
                    <p>Tambah data customer baru.</p>
                </p>
                                        <h2 id="customer-POSTapi-customers">POST api/customers</h2>

<p>
</p>



<span id="example-requests-POSTapi-customers">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://rest-api.test/api/customers" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"name\": \"PT ABC\",
    \"address\": \"Jl. Sudirman No. 1\",
    \"phone\": \"628123456789\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://rest-api.test/api/customers"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "PT ABC",
    "address": "Jl. Sudirman No. 1",
    "phone": "628123456789"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-customers">
            <blockquote>
            <p>Example response (201, Sukses):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;id&quot;: 1,
    &quot;name&quot;: &quot;PT ABC&quot;,
    &quot;address&quot;: &quot;Jl. Sudirman No. 1&quot;,
    &quot;phone&quot;: &quot;628123456789&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (422, Gagal validasi):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: false,
    &quot;message&quot;: &quot;Invalid phone number&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-customers" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-customers"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-customers"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-customers" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-customers">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-customers" data-method="POST"
      data-path="api/customers"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-customers', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-customers"
                    onclick="tryItOut('POSTapi-customers');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-customers"
                    onclick="cancelTryOut('POSTapi-customers');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-customers"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/customers</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-customers"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-customers"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="name"                data-endpoint="POSTapi-customers"
               value="PT ABC"
               data-component="body">
    <br>
<p>Nama customer. Example: <code>PT ABC</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>address</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="address"                data-endpoint="POSTapi-customers"
               value="Jl. Sudirman No. 1"
               data-component="body">
    <br>
<p>Alamat customer. Example: <code>Jl. Sudirman No. 1</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>phone</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="phone"                data-endpoint="POSTapi-customers"
               value="628123456789"
               data-component="body">
    <br>
<p>Nomor telepon customer. Example: <code>628123456789</code></p>
        </div>
        </form>

                                <h2 id="customer-update">Update</h2>
                                        <p>
                    <p>Update data customer.</p>
                </p>
                                        <h2 id="customer-PUTapi-customers--id-">PUT api/customers/{id}</h2>

<p>
</p>



<span id="example-requests-PUTapi-customers--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PUT \
    "http://rest-api.test/api/customers/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"name\": \"PT DEF\",
    \"address\": \"Jl. Thamrin No. 2\",
    \"phone\": \"628129876543\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://rest-api.test/api/customers/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "PT DEF",
    "address": "Jl. Thamrin No. 2",
    "phone": "628129876543"
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-PUTapi-customers--id-">
            <blockquote>
            <p>Example response (200, Sukses):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;id&quot;: 1,
    &quot;name&quot;: &quot;PT DEF&quot;,
    &quot;address&quot;: &quot;Jl. Thamrin No. 2&quot;,
    &quot;phone&quot;: &quot;628129876543&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (422, Gagal validasi):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: false,
    &quot;message&quot;: &quot;Invalid phone number&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-PUTapi-customers--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PUTapi-customers--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-customers--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PUTapi-customers--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-customers--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PUTapi-customers--id-" data-method="PUT"
      data-path="api/customers/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PUTapi-customers--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PUTapi-customers--id-"
                    onclick="tryItOut('PUTapi-customers--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PUTapi-customers--id-"
                    onclick="cancelTryOut('PUTapi-customers--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PUTapi-customers--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/customers/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PUTapi-customers--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="PUTapi-customers--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="PUTapi-customers--id-"
               value="1"
               data-component="url">
    <br>
<p>ID customer yang akan diupdate. Example: <code>1</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="name"                data-endpoint="PUTapi-customers--id-"
               value="PT DEF"
               data-component="body">
    <br>
<p>Nama customer. Example: <code>PT DEF</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>address</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="address"                data-endpoint="PUTapi-customers--id-"
               value="Jl. Thamrin No. 2"
               data-component="body">
    <br>
<p>Alamat customer. Example: <code>Jl. Thamrin No. 2</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>phone</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="phone"                data-endpoint="PUTapi-customers--id-"
               value="628129876543"
               data-component="body">
    <br>
<p>Nomor telepon customer. Example: <code>628129876543</code></p>
        </div>
        </form>

                    <h2 id="customer-PATCHapi-customers--id-">PATCH api/customers/{id}</h2>

<p>
</p>



<span id="example-requests-PATCHapi-customers--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PATCH \
    "http://rest-api.test/api/customers/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"name\": \"PT DEF\",
    \"address\": \"Jl. Thamrin No. 2\",
    \"phone\": \"628129876543\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://rest-api.test/api/customers/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "PT DEF",
    "address": "Jl. Thamrin No. 2",
    "phone": "628129876543"
};

fetch(url, {
    method: "PATCH",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-PATCHapi-customers--id-">
            <blockquote>
            <p>Example response (200, Sukses):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;id&quot;: 1,
    &quot;name&quot;: &quot;PT DEF&quot;,
    &quot;address&quot;: &quot;Jl. Thamrin No. 2&quot;,
    &quot;phone&quot;: &quot;628129876543&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (422, Gagal validasi):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: false,
    &quot;message&quot;: &quot;Invalid phone number&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-PATCHapi-customers--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PATCHapi-customers--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PATCHapi-customers--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PATCHapi-customers--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PATCHapi-customers--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PATCHapi-customers--id-" data-method="PATCH"
      data-path="api/customers/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PATCHapi-customers--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PATCHapi-customers--id-"
                    onclick="tryItOut('PATCHapi-customers--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PATCHapi-customers--id-"
                    onclick="cancelTryOut('PATCHapi-customers--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PATCHapi-customers--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-purple">PATCH</small>
            <b><code>api/customers/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PATCHapi-customers--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="PATCHapi-customers--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="PATCHapi-customers--id-"
               value="1"
               data-component="url">
    <br>
<p>ID customer yang akan diupdate. Example: <code>1</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="name"                data-endpoint="PATCHapi-customers--id-"
               value="PT DEF"
               data-component="body">
    <br>
<p>Nama customer. Example: <code>PT DEF</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>address</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="address"                data-endpoint="PATCHapi-customers--id-"
               value="Jl. Thamrin No. 2"
               data-component="body">
    <br>
<p>Alamat customer. Example: <code>Jl. Thamrin No. 2</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>phone</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="phone"                data-endpoint="PATCHapi-customers--id-"
               value="628129876543"
               data-component="body">
    <br>
<p>Nomor telepon customer. Example: <code>628129876543</code></p>
        </div>
        </form>

                <h1 id="endpoints">Endpoints</h1>

    

                                <h2 id="endpoints-GETapi-user">GET api/user</h2>

<p>
</p>



<span id="example-requests-GETapi-user">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://rest-api.test/api/user" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://rest-api.test/api/user"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-user">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-user" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-user"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-user"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-user" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-user">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-user" data-method="GET"
      data-path="api/user"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-user', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-user"
                    onclick="tryItOut('GETapi-user');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-user"
                    onclick="cancelTryOut('GETapi-user');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-user"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/user</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-user"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-user"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                <h1 id="laporan-transaksi-bulanan">Laporan Transaksi Bulanan</h1>

    <p>Endpoint terkait laporan dan analitik transaksi bulanan, target, dan performa sales.</p>
<p>Semua endpoint di grup ini digunakan untuk kebutuhan dashboard, analitik, dan pelaporan performa penjualan.
Data yang dihasilkan siap digunakan untuk visualisasi grafik bulanan dan analisis tren penjualan.</p>

                        <h2 id="laporan-transaksi-bulanan-ringkasan-transaksi-3-tahun-terakhir">Ringkasan Transaksi 3 Tahun Terakhir</h2>
                                        <p>
                    <p>Dapatkan data agregasi transaksi penjualan per bulan untuk 3 tahun terakhir.
Bisa difilter berdasarkan customer maupun sales tertentu.</p>
                </p>
                                        <h2 id="laporan-transaksi-bulanan-GETapi-monthly-transactions">GET api/monthly-transactions</h2>

<p>
</p>



<span id="example-requests-GETapi-monthly-transactions">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://rest-api.test/api/monthly-transactions?customer_id=17&amp;sales_id=17" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://rest-api.test/api/monthly-transactions"
);

const params = {
    "customer_id": "17",
    "sales_id": "17",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-monthly-transactions">
            <blockquote>
            <p>Example response (200, Sukses - Data dengan filter customer dan sales):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
  &quot;customer&quot;: { &quot;id&quot;: 1, &quot;name&quot;: &quot;PT ABC Corporation&quot;, &quot;address&quot;: &quot;...&quot;, &quot;phone&quot;: &quot;...&quot; },
  &quot;sales&quot;: { &quot;id&quot;: 5, &quot;sales_name&quot;: &quot;John Doe&quot;, &quot;phone&quot;: &quot;...&quot;, &quot;area_name&quot;: &quot;...&quot; },
  &quot;items&quot;: [
    { &quot;name&quot;: 2024, &quot;data&quot;: [ {&quot;x&quot;: &quot;Jan&quot;, &quot;y&quot;: &quot;15000000.00&quot;}, ... ] },
    { &quot;name&quot;: 2023, &quot;data&quot;: [ {&quot;x&quot;: &quot;Jan&quot;, &quot;y&quot;: &quot;12000000.00&quot;}, ... ] }
  ],
  &quot;summary&quot;: { &quot;total_amount&quot;: &quot;...&quot;, &quot;total_orders&quot;: 267, ... }
}</code>
 </pre>
            <blockquote>
            <p>Example response (400, Parameter Tidak Valid):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;error&quot;: &quot;Parameter customer_id atau sales_id tidak valid&quot;,
    &quot;message&quot;: &quot;ID yang diberikan tidak ditemukan dalam database&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (500, Kesalahan Server):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;error&quot;: &quot;Terjadi kesalahan server&quot;,
    &quot;message&quot;: &quot;Gagal mengambil data transaksi bulanan&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-monthly-transactions" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-monthly-transactions"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-monthly-transactions"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-monthly-transactions" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-monthly-transactions">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-monthly-transactions" data-method="GET"
      data-path="api/monthly-transactions"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-monthly-transactions', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-monthly-transactions"
                    onclick="tryItOut('GETapi-monthly-transactions');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-monthly-transactions"
                    onclick="cancelTryOut('GETapi-monthly-transactions');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-monthly-transactions"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/monthly-transactions</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-monthly-transactions"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-monthly-transactions"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>customer_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="customer_id"                data-endpoint="GETapi-monthly-transactions"
               value="17"
               data-component="query">
    <br>
<p>optional ID customer untuk memfilter data transaksi. Contoh: 1 Example: <code>17</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>sales_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="sales_id"                data-endpoint="GETapi-monthly-transactions"
               value="17"
               data-component="query">
    <br>
<p>optional ID sales untuk memfilter data transaksi. Contoh: 5 Example: <code>17</code></p>
            </div>
                </form>

                                <h2 id="laporan-transaksi-bulanan-target-revenue-dan-income-bulanan">Target, Revenue, dan Income Bulanan</h2>
                                        <p>
                    <p>Mendapatkan data target, revenue, dan income bulanan dalam format siap chart.
Bisa difilter berdasarkan tahun dan sales tertentu.</p>
                </p>
                                        <h2 id="laporan-transaksi-bulanan-GETapi-monthly-transactions-targets-and-transactions">GET api/monthly-transactions/targets-and-transactions</h2>

<p>
</p>



<span id="example-requests-GETapi-monthly-transactions-targets-and-transactions">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://rest-api.test/api/monthly-transactions/targets-and-transactions?year=17&amp;sales_id=17" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://rest-api.test/api/monthly-transactions/targets-and-transactions"
);

const params = {
    "year": "17",
    "sales_id": "17",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-monthly-transactions-targets-and-transactions">
            <blockquote>
            <p>Example response (200, Sukses):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
  &quot;sales&quot;: null,
  &quot;year&quot;: &quot;2025&quot;,
  &quot;items&quot;: [
    { &quot;name&quot;: &quot;Target&quot;, &quot;data&quot;: [ {&quot;x&quot;: &quot;Jan&quot;, &quot;y&quot;: &quot;18940000000.00&quot;}, ... ] },
    { &quot;name&quot;: &quot;Revenue&quot;, &quot;data&quot;: [ {&quot;x&quot;: &quot;Jan&quot;, &quot;y&quot;: &quot;15677673700.00&quot;}, ... ] },
    { &quot;name&quot;: &quot;Income&quot;, &quot;data&quot;: [ {&quot;x&quot;: &quot;Jan&quot;, &quot;y&quot;: &quot;2028803700.00&quot;}, ... ] }
  ]
}</code>
 </pre>
            <blockquote>
            <p>Example response (500, Kesalahan Server):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;error&quot;: &quot;Terjadi kesalahan server&quot;,
    &quot;message&quot;: &quot;Gagal mengambil data target dan transaksi bulanan&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-monthly-transactions-targets-and-transactions" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-monthly-transactions-targets-and-transactions"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-monthly-transactions-targets-and-transactions"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-monthly-transactions-targets-and-transactions" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-monthly-transactions-targets-and-transactions">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-monthly-transactions-targets-and-transactions" data-method="GET"
      data-path="api/monthly-transactions/targets-and-transactions"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-monthly-transactions-targets-and-transactions', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-monthly-transactions-targets-and-transactions"
                    onclick="tryItOut('GETapi-monthly-transactions-targets-and-transactions');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-monthly-transactions-targets-and-transactions"
                    onclick="cancelTryOut('GETapi-monthly-transactions-targets-and-transactions');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-monthly-transactions-targets-and-transactions"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/monthly-transactions/targets-and-transactions</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-monthly-transactions-targets-and-transactions"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-monthly-transactions-targets-and-transactions"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>year</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="year"                data-endpoint="GETapi-monthly-transactions-targets-and-transactions"
               value="17"
               data-component="query">
    <br>
<p>Tahun yang diambil. Default: tahun ini. Contoh: 2025 Example: <code>17</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>sales_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="sales_id"                data-endpoint="GETapi-monthly-transactions-targets-and-transactions"
               value="17"
               data-component="query">
    <br>
<p>optional ID sales untuk filter. Contoh: 1 Example: <code>17</code></p>
            </div>
                </form>

                                <h2 id="laporan-transaksi-bulanan-performa-sales-bulanan">Performa Sales Bulanan</h2>
                                        <p>
                    <p>Mendapatkan performa seluruh sales dalam 1 bulan, termasuk revenue, target, dan persentase pencapaian.
Bisa difilter berdasarkan bulan, tahun, dan status underperform.</p>
                </p>
                                        <h2 id="laporan-transaksi-bulanan-GETapi-monthly-sales-performance">GET api/monthly-sales-performance</h2>

<p>
</p>



<span id="example-requests-GETapi-monthly-sales-performance">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://rest-api.test/api/monthly-sales-performance?month=17&amp;year=17&amp;isUnderperform=" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://rest-api.test/api/monthly-sales-performance"
);

const params = {
    "month": "17",
    "year": "17",
    "isUnderperform": "0",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-monthly-sales-performance">
            <blockquote>
            <p>Example response (200, Sukses):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;is_underperform&quot;: null,
    &quot;month&quot;: &quot;April 2025&quot;,
    &quot;items&quot;: [
        {
            &quot;sales&quot;: &quot;Salimah Handayani&quot;,
            &quot;revenue&quot;: {
                &quot;amount&quot;: &quot;136796400.00&quot;,
                &quot;abbreviation&quot;: &quot;136.8M&quot;
            },
            &quot;target&quot;: {
                &quot;amount&quot;: &quot;560000000.00&quot;,
                &quot;abbreviation&quot;: &quot;560M&quot;
            },
            &quot;percentage&quot;: &quot;24.43&quot;
        }
    ]
}</code>
 </pre>
            <blockquote>
            <p>Example response (500, Kesalahan Server):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;error&quot;: &quot;Terjadi kesalahan server&quot;,
    &quot;message&quot;: &quot;Gagal mengambil data performa sales bulanan&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-monthly-sales-performance" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-monthly-sales-performance"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-monthly-sales-performance"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-monthly-sales-performance" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-monthly-sales-performance">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-monthly-sales-performance" data-method="GET"
      data-path="api/monthly-sales-performance"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-monthly-sales-performance', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-monthly-sales-performance"
                    onclick="tryItOut('GETapi-monthly-sales-performance');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-monthly-sales-performance"
                    onclick="cancelTryOut('GETapi-monthly-sales-performance');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-monthly-sales-performance"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/monthly-sales-performance</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-monthly-sales-performance"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-monthly-sales-performance"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>month</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="month"                data-endpoint="GETapi-monthly-sales-performance"
               value="17"
               data-component="query">
    <br>
<p>Bulan (1-12), default: bulan ini. Contoh: 4 Example: <code>17</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>year</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="year"                data-endpoint="GETapi-monthly-sales-performance"
               value="17"
               data-component="query">
    <br>
<p>Tahun, default: tahun ini. Contoh: 2025 Example: <code>17</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>isUnderperform</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
                <label data-endpoint="GETapi-monthly-sales-performance" style="display: none">
            <input type="radio" name="isUnderperform"
                   value="1"
                   data-endpoint="GETapi-monthly-sales-performance"
                   data-component="query"             >
            <code>true</code>
        </label>
        <label data-endpoint="GETapi-monthly-sales-performance" style="display: none">
            <input type="radio" name="isUnderperform"
                   value="0"
                   data-endpoint="GETapi-monthly-sales-performance"
                   data-component="query"             >
            <code>false</code>
        </label>
    <br>
<p>Filter sales underperform (true/false), default: null (all) Example: <code>false</code></p>
            </div>
                </form>

                <h1 id="sales-order">Sales Order</h1>

    

                        <h2 id="sales-order-create">Create</h2>
                                        <p>
                    <p>Tambah data penjualan (sales order) beserta detail item.</p>
                </p>
                                        <h2 id="sales-order-POSTapi-sales-orders">POST api/sales-orders</h2>

<p>
</p>



<span id="example-requests-POSTapi-sales-orders">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://rest-api.test/api/sales-orders" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"reference_no\": \"SO-20240620-001\",
    \"sales_id\": 1,
    \"customer_id\": 2,
    \"items\": [
        \"consequatur\"
    ]
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://rest-api.test/api/sales-orders"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "reference_no": "SO-20240620-001",
    "sales_id": 1,
    "customer_id": 2,
    "items": [
        "consequatur"
    ]
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-sales-orders">
            <blockquote>
            <p>Example response (201, Sukses):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;id&quot;: 1,
    &quot;reference_no&quot;: &quot;SO-20240620-001&quot;,
    &quot;sales_id&quot;: 1,
    &quot;customer_id&quot;: 2,
    &quot;sales_order_items&quot;: [
        {
            &quot;id&quot;: 1,
            &quot;product_id&quot;: 3,
            &quot;quantity&quot;: 10,
            &quot;production_price&quot;: &quot;50000.00&quot;,
            &quot;selling_price&quot;: &quot;75000.00&quot;
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-sales-orders" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-sales-orders"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-sales-orders"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-sales-orders" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-sales-orders">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-sales-orders" data-method="POST"
      data-path="api/sales-orders"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-sales-orders', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-sales-orders"
                    onclick="tryItOut('POSTapi-sales-orders');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-sales-orders"
                    onclick="cancelTryOut('POSTapi-sales-orders');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-sales-orders"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/sales-orders</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-sales-orders"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-sales-orders"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>reference_no</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="reference_no"                data-endpoint="POSTapi-sales-orders"
               value="SO-20240620-001"
               data-component="body">
    <br>
<p>Nomor referensi order. Example: <code>SO-20240620-001</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>sales_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="sales_id"                data-endpoint="POSTapi-sales-orders"
               value="1"
               data-component="body">
    <br>
<p>ID sales. Example: <code>1</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>customer_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="customer_id"                data-endpoint="POSTapi-sales-orders"
               value="2"
               data-component="body">
    <br>
<p>ID customer. Example: <code>2</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
        <details>
            <summary style="padding-bottom: 10px;">
                <b style="line-height: 2;"><code>items</code></b>&nbsp;&nbsp;
<small>string[]</small>&nbsp;
 &nbsp;
<br>
<p>Daftar item penjualan.</p>
            </summary>
                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>product_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="items.0.product_id"                data-endpoint="POSTapi-sales-orders"
               value="3"
               data-component="body">
    <br>
<p>ID produk. Example: <code>3</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>quantity</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="items.0.quantity"                data-endpoint="POSTapi-sales-orders"
               value="10"
               data-component="body">
    <br>
<p>Jumlah produk. Example: <code>10</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>production_price</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="items.0.production_price"                data-endpoint="POSTapi-sales-orders"
               value="50000"
               data-component="body">
    <br>
<p>Harga pokok. Example: <code>50000</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>selling_price</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="items.0.selling_price"                data-endpoint="POSTapi-sales-orders"
               value="75000"
               data-component="body">
    <br>
<p>Harga jual. Example: <code>75000</code></p>
                    </div>
                                    </details>
        </div>
        </form>

            

        
    </div>
    <div class="dark-box">
                    <div class="lang-selector">
                                                        <button type="button" class="lang-button" data-language-name="bash">bash</button>
                                                        <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                            </div>
            </div>
</div>
</body>
</html>
