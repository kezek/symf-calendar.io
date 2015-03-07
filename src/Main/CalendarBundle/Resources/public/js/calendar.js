$(document).ready(function () {

    // page is now ready, initialize the calendar...

    $('#calendar').fullCalendar({
        selectable: true,
        editable: true,

        formatDate: 'Y',
        eventLimit: true,
        firstDay: 1,
        events: {
            url: getEventsUrl
        },
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        select: function (start, end) {
            var title = prompt('Event Title:');
            var eventData;
            if (title) {
                eventData = {
                    title: title,
                    start: start,
                    end: end
                };
                $.ajax({
                        type: "POST",
                        url: postEventUrl,
                        data: {'date': start.format(), 'title': title}
                    }
                ).done(function (data) {
                        //create DOM element with id retrieved from server side
                        eventData.id = data.id;
                        $('#calendar').fullCalendar('renderEvent', eventData, true);
                    });
            }
            $('#calendar').fullCalendar('unselect');
        },
        eventClick: function (event) {
            var title = prompt('Edit:');
            event.title = title;
            if (title) {
                $('#calendar').fullCalendar('updateEvent', event);
                $.ajax({
                        type: "PUT",
                        url: postEventUrl + '/' + event.id,
                        data: {'title': title}
                    }
                );
            }
        },
        // when moving to another day
        eventDrop: function (event, revertFunc) {
            console.log(event);
            if (!confirm("Are you sure about that?")) {
                revertFunc();
            }
            $.ajax({
                    type: "PUT",
                    url: postEventUrl + '/' + event.id,
                    data: {'date': event.start.format()}
                }
            );
        },
        eventDragStop: function (event, jsEvent) {
            if ((jsEvent.pageX <= 250) & (jsEvent.pageY <= 250)) {
                if (confirm('Delete ' + event.title + ' ?')) {
                    $('#calendar').fullCalendar('removeEvents', event.id);
                    $.ajax({
                        type: "DELETE",
                        url: deleteEventUrl + '/' + event.id
                    });
                }
            }
        }
    })

});
