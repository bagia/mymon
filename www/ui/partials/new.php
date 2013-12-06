<div class="content">
    <script>
        $(function () {
            $("#progressbar").progressbar({
                value: 0
            });
        });
    </script>
    <h3>Deploy a new watchdog</h3>

    <div id="progressbar"></div>
    <form id="mainForm" ng-submit="submit()">
        <p>
            <label for="link">Give us a link to an article you think your friends will ignore if published on your
                profile:</label>
            <input name="link" id="link" type="text" ng-model="link" required="required" placeholder="http://www.example.com/article" />
        </p>

        <p>
            <label for="name">Name this watchdog:</label>
            <input name="name" id="name" type="text" ng-model="name" required="required" placeholder="Public" />
        </p>

        <p>
            <div class="radio_buttons">
                <label for="notify_user">Do you want to enable notifications on this Watchdog?</label>
                <label for="1">Yes</label>
                <input type="radio" name="notify_user" id="notify_user" value="1" ng-model="notify_user"/>
                <label for="0">No</label>
                <input type="radio" name="notify_user" id="notify_user" value="0" ng-model="notify_user"/>
            </div>
        </p>
        <div id="submit_button_placeholder">
            <button id="submit_button" type="submit">Publish</button>
        </div>

    </form>
</div>

