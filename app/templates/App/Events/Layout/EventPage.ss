<div class="section section--events">
    <div class="section_content">
        <h1>$Title</h1>

        <% if $Events %>
            <div class="events_navigator" data-behaviour="eventsNavigator">
                <div class="events_navigator_step dates hidden" data-eventstep="1">
                    <h2>1. Datum wählen</h2>
                    <div class="section_selectablelist">
                        <% loop $GroupedEvents.GroupedBy('EventDate') %>
                            <div class="date_card" data-behaviour="date" data-date="$Children.First.EventDate">
                                <p class="date_card_date">$Children.First.DateFormatted</p>
                            </div>
                        <% end_loop %>
                    </div>
                </div>

                <div class="events_navigator_step events hidden" data-eventstep="2">
                    <h2>2. Veranstaltung wählen</h2>
                    <div class="section_selectablelist">
                        <% loop $GroupedEvents.GroupedBy('EventDate') %>
                            <% loop $Children %>
                                <div class="event_card" data-behaviour="event" data-date="$EventDate" data-eventID="$ID">
                                    <p class="event_card_title">$Title</p>
                                </div>
                            <% end_loop %>
                        <% end_loop %>
                    </div>
                </div>

                <div class="events_navigator_step timeslots hidden" data-eventstep="3">
                    <h2>3. Zeitslot wählen</h2>
                    <div class="section_selectablelist">
                        <% loop $GroupedEvents.GroupedBy('EventDate') %>
                            <% loop $Children %>
                                <% loop TimeSlots %>
                                    <div class="timeslot_card" data-behaviour="timeslot" data-eventID="$Parent.ID">
                                        <p class="timeslot_card_time">$SlotTimeFormatted</p>
                                    </div>
                                <% end_loop %>
                            <% end_loop %>
                        <% end_loop %>
                    </div>
                </div>

                <div class="events_navigator_step form hidden" data-eventstep="4">
                    $RegistrationForm
                </div>
            </div>
        <% end_if %>
    </div>
</div>
