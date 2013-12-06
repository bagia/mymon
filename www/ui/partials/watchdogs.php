<div class="content">
    <h3>My watchdogs</h3>
    <a href="/#/new">new</a>
    <div id="accordion">
            <h3 ng-repeat-start="watchdog in watchdogs" accordion-directive>#{{watchdog.id}} {{watchdog.name}}</h3>
            <div class="watchdog-detail" id="wd-{{watchdog.id}}" ng-repeat-end>
                <div class="summary">
                    <div class="history-count">Number of visits: {{watchdog.history_count}}</div>
                    <div class="delete-link"><a ng-click="delete(watchdog.id)">delete</a></div>
                </div>
                <div class="history">
                    <h4>History</h4>
                    <ul>
                        <li ng-repeat="history in watchdog.history">On <b>{{history.date}}</b> by <b>{{history.user_agent}}</b></li>
                    </ul>
                </div>
            </div>
    </div>
</div>

