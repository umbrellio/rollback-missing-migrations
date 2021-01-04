<nav class="flex">
    <header class="px-4 py-3">
        {{ $header }}
    </header>

    <div class="ml-auto md:ml-0 relative">
        <a class="inline-block md:hidden navigation__toggle px-4 py-3 text-black" href="#!" onclick="return false;">
            <fa-icon icon="bars" />
        </a>

        <ul class="navigation__items">
            <li class="md:inline-block px-4 py-3"><a href="#">Item 1</a></li>
            <li class="md:inline-block px-4 py-3"><a href="#">Item 2</a></li>
            <li class="md:inline-block px-4 py-3"><a href="#">Item 3</a></li>
            <li class="md:inline-block px-4 py-3"><a href="#">Item 4</a></li>
        </ul>
    </div>
</nav>
