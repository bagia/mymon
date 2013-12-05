<div class="content">
    <h3>My watchdogs</h3>
    <div id="accordion">
            <h3 ng-repeat-start="watchdog in watchdogs" accordion-directive>#{{$index}} {{watchdog.name}}</h3>
            <div ng-repeat-end>
                <div class="summary">
                    <div class="history_count">Number of visits: {{watchdog.history_count}}</div>
                </div>
                <div class="history">
                    <ul>
                        <li ng-repeat="history in watchdog.history">{{history.id}}: {{history.date}}</li>
                    </ul>
                </div>
            </div>
    </div>
</div>

