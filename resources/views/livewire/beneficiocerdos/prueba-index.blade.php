<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Hello World</title>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
         @include('layouts.theme.styles')


    </head>
    <body>
        @include('layouts.theme.scripts')

<div class="min-h-screen p-16 bg-gray-100">
    
<!-- https://github.com/KevinBatdorf/alpine-magic-helpers -->
<!-- https://cdn.jsdelivr.net/gh/kevinbatdorf/alpine-magic-helpers@latest/dist/interval.js -->
    
<div
    x-data="{
        timer: 500,
        count: 0,
        addOne: function() {
            this.count++
        }
    }"
    x-init="$interval(addOne, timer)"
    x-text="count.toString()">
</div>
    
    
    
    
    
    
</div>


<!-- Dev tools -->
<div
    id="alpine-devtools"
    x-data="devtools()"
    x-show="alpines.length"
    x-init="start()">
</div>


    

   @livewireScripts
    </body>
</html>
