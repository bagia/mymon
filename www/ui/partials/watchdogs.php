<div class="content">
    <h3>My watchdogs</h3>
    <div id="accordion">
            <h3 ng-repeat-start="watchdog in watchdogs" accordion-directive>#{{$index}} {{watchdog.name}}</h3>
            <div ng-repeat-end>
                <p>
                    Mauris mauris ante, blandit et, ultrices a, suscipit eget, quam. Integer
                    ut neque. Vivamus nisi metus, molestie vel, gravida in, condimentum sit
                    amet, nunc. Nam a nibh. Donec suscipit eros. Nam mi. Proin viverra leo ut
                    odio. Curabitur malesuada. Vestibulum a velit eu ante scelerisque vulputate.
                </p>
            </div>
    </div>
</div>

