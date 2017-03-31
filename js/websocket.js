/**
 * Created by joao on 30/03/17.
 */

$(document).ready(function () {

});

var connection = new autobahn.Connection({
    url: 'ws://127.0.0.1:9090/',
    realm: 'realm1',
    authmethods: ['jwt'],
    onchallenge: function (session, method, extra) {
        if (method === 'jwt') {
            // you could also return a promise here
            return 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJhdXRoaWQiOiJqb2FvIiwiYXV0aHJvbGVzIjpbInVzZXIiLCJkaXIiXX0.fagwxe3Ob8mrQFYSfP-bNlcSxaO4p20MBhEpABkmrfo';
        }
    }
});

connection.onopen = function (session, details) {
    console.log("Successfully made the socket connection as " + details.authid + ".");
    // this won't work - we are not allowed
    session.subscribe("some.randome.uri", function () {
    }).then(
        function () {
            console.log("successfully subscribed");
        },
        function () {
            console.log("There was an error subscribing.");
        });

    // this will work - we are in the sales group and can subscribe
    session.subscribe("sales.numbers", function () {
    }).then(
        function () {
            console.log("successfully subscribed");
        },
        function () {
            console.log("There was an error subscribing.");
        });


    // 1) subscribe to a topic
    /*function onevent(args) {
        console.log("Event:", args[0]);
    }

    session.subscribe('com.myapp.hello', onevent);

    // 2) publish an event
    session.publish('com.myapp.hello', ['Hello, world!']);

    // 3) register a procedure for remoting
    function add2(args) {
        return args[0] + args[1];
    }

    session.register('com.myapp.add2', add2);

    // 4) call a remote procedure
    session.call('com.myapp.add2', [2, 3]).then(
        function (res) {
            console.log("Result:", res);
        }
    );

    session.call('com.example.getphpversion').then(function (res) {
        console.log("PHP Version:", res);
    });*/
};

connection.onclose = function(reason, details) {
    console.log("Connection close: " + reason);
};

connection.open();
