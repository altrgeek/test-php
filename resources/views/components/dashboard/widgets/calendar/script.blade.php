@props([
    'appointments' => null,
    'route' => null,
])
<script type="text/javascript">
    "use strict";
    ! function(NioApp, $) {
        "use strict"; // Variable

        var $win = $(window),
            $body = $('body'),
            breaks = NioApp.Break;

        NioApp.Calendar = function() {
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0');
            var yyyy = today.getFullYear();
            var tomorrow = new Date(today);
            tomorrow.setDate(today.getDate() + 1);
            var t_dd = String(tomorrow.getDate()).padStart(2, '0');
            var t_mm = String(tomorrow.getMonth() + 1).padStart(2, '0');
            var t_yyyy = tomorrow.getFullYear();
            var yesterday = new Date(today);
            yesterday.setDate(today.getDate() - 1);
            var y_dd = String(yesterday.getDate()).padStart(2, '0');
            var y_mm = String(yesterday.getMonth() + 1).padStart(2, '0');
            var y_yyyy = yesterday.getFullYear();
            var YM = yyyy + '-' + mm;
            var YESTERDAY = y_yyyy + '-' + y_mm + '-' + y_dd;
            var TODAY = yyyy + '-' + mm + '-' + dd;
            var TOMORROW = t_yyyy + '-' + t_mm + '-' + t_dd;
            var month = [
                "January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November",
                "December"
            ];
            var calendarEl = document.getElementById('calendar');
            var eventsEl = document.getElementById('externalEvents');
            var addEventForm = $('#addEventForm');
            var addEventPopup = $('#addEventPopup');
            var mobileView = NioApp.Win.width < NioApp.Break.md ? true : false;
            var calendar = new FullCalendar.Calendar(calendarEl, {
                timeZone: 'UTC',
                initialView: mobileView ? 'listWeek' : 'dayGridMonth',
                themeSystem: 'bootstrap',
                headerToolbar: {
                    left: 'title prev,next',
                    center: null,
                    right: 'today dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                height: 800,
                contentHeight: 780,
                aspectRatio: 3,
                editable: true,
                droppable: false,
                views: {
                    dayGridMonth: {
                        dayMaxEventRows: 2
                    }
                },
                direction: NioApp.State.isRTL ? "rtl" : "ltr",
                nowIndicator: true,
                now: TODAY + 'T09:25:00',
                eventDragStart: function eventDragStart(info) {
                    $('.popover').popover('hide');
                },
                eventMouseEnter: function eventMouseEnter(info) {
                    $(info.el).popover({
                        template: '<div class="popover"><div class="arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>',
                        title: info.event._def.title,
                        content: info.event._def.extendedProps.description,
                        placement: 'top'
                    });
                    info.event._def.extendedProps.description ? $(info.el).popover('show') : $(info.el)
                        .popover('hide');
                },
                eventMouseLeave: function eventMouseLeave(info) {
                    $(info.el).popover('hide');
                },
                eventClick: function eventClick(info) {
                    var eventId = info.event._def.publicId;
                    window.location.href = "{{ route($route, ':id') }}".replace(':id', eventId)
                },
                events: [
                    @foreach ($appointments as $appointment)
                        @php
                            switch ($appointment->status) {
                                case 'declined':
                                    $className = 'danger';
                                    $state = 'declined';
                                    break;
                                case 'booked':
                                    $className = 'warning-dim';
                                    $state = 'pending review';
                                    break;
                                case 'reviewed':
                                    $className = 'warning';
                                    $state = 'unpaid';
                                    break;
                                case 'pending':
                                    $className = 'success';
                                    $state = 'ready';
                                    break;
                                case 'completed':
                                    $className = 'success-dim';
                                    $state = 'completed';
                                    break;
                                case 'accepted':
                                    $className = 'primary';
                                    $state = 'accepted';
                                    break;
                                case 'rejected':
                                    $className = 'danger';
                                    $state = 'rejected';
                                    break;
                                default:
                                    $className = 'primary-dim';
                                    break;
                            }
                            $state = collect(explode(' ', $state))
                                ->map(function ($word) {
                                    return ucfirst($word);
                                })
                                ->join(' ');
                        @endphp
                        {
                        id: {{ $appointment->id }},
                        title: "{{ sprintf('%s (%s)', $appointment->title, $state) }}",
                        start: "{{ $appointment->start }}",
                        className: "fc-event-{{ $className }}",
                        description: "{{ $appointment->description }}"
                        },
                    @endforeach
                ],
            });
            calendar.render();

            function customCalSelect(cat) {
                if (!cat.id) {
                    return cat.text;
                }

                var $cat = $('<span class="fc-' + cat.element.value + '"> <span class="dot"></span>' + cat.text +
                    '</span>');
                return $cat;
            };

            NioApp.Select2('.select-calendar-theme', {
                templateResult: customCalSelect
            });

            addEventPopup.on('hidden.bs.modal', function(e) {
                setTimeout(function() {
                    $('#addEventForm input,#addEventForm textarea').val('');
                    $('#event-theme').val('event-primary');
                    $('#event-theme').trigger('change.select2');
                }, 1000);
            });
        };
        NioApp.coms.docReady.push(NioApp.Calendar);
    }(NioApp, jQuery);
</script>
