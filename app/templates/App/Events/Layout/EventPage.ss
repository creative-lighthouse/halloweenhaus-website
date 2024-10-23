<div class="section section--events">
    <div class="section_content">
        <h1>$Title</h1>

        <% if $Events %>
            <div class="events_navigator" data-behaviour="eventsNavigator">

                <% if $UsesCoupon %>
                    <div class="events_navigator_step coupon" data-eventstep="coupon">
                        <h3>Du hast einen Coupon von uns erhalten?</h3>
                        <div class="section_couponform" data-behaviour="coupon_form">
                            <input type="text" class="coupon_input" data-behaviour="coupon_input" placeholder="Couponcode eingeben">
                            <button class="coupon_button" data-behaviour="coupon_button">Absenden</button>
                        </div>
                        <p class="coupon_message" data-behaviour="coupon_message">Bitte gib deinen Couponcode ein</p>
                        <a class="coupon_reset" data-behaviour="coupon_reset">X Coupon entfernen</a>
                        <p class="coupon_description" data-behaviour="coupon_description"></p>
                    </div>
                <% end_if %>

                <div class="events_navigator_step dates hidden" data-eventstep="1">
                    <h2>1. Datum wählen</h2>
                    <div class="section_selectablelist">
                        <% loop $GroupedEvents.GroupedBy('EventDate') %>
                            <div class="date_card" data-behaviour="date" data-date="$Children.First.EventDate">
                                <p class="date_card_weekday">$Children.First.DateWeekday</p>
                                <p class="date_card_day">$Children.First.DateDay</p>
                                <p class="date_card_month">$Children.First.DateMonthTitle</p>
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
                                    <div class="event_card_image">
                                        <% if $Image %><img src="$Image.FocusFill(500, 200).URL" alt="$Image.Title"><% end_if %>
                                    </div>
                                    <div class="event_card_text">
                                        <p class="event_card_title">$Title</p>
                                        <p class="event_card_duration">Dauer: ca. $SlotDuration Minuten</p>
                                    </div>
                                </div>
                            <% end_loop %>
                        <% end_loop %>
                    </div>
                </div>

                <div class="events_navigator_step timeslots hidden" data-eventstep="3">
                    <h2>3. Startzeit wählen</h2>
                    <div class="section_selectablelist">
                        <% loop $GroupedEvents.GroupedBy('EventDate') %>
                            <% loop $Children %>
                                <% if $FreeTimeSlotsInFuture.Count > 0 %>
                                    <% loop $FreeTimeSlotsInFuture %>
                                        <div class="timeslot_card" data-behaviour="timeslot" data-slotId="$ID" data-slotsize="$getFreeSlotCount" data-eventID="$Parent.ID">
                                            <p class="timeslot_card_time">$SlotTimeFormatted</p>
                                            <p class="timeslot_card_capacity">$AttendeesFormatted</p>
                                        </div>
                                    <% end_loop %>
                                    <% loop $FullTimeSlots %>
                                        <div class="timeslot_card timeslot_card--full" data-behaviour="timeslot" data-slotId="$ID" data-slotsize="0" data-eventID="$Parent.ID">
                                            <p class="timeslot_card_time">$SlotTimeFormatted</p>
                                            <p class="timeslot_card_capacity">Ausgebucht!</p>
                                        </div>
                                    <% end_loop %>
                                <% else %>
                                    <p class="timeslot_card timeslot_card--text" data-behaviour="timeslot" data-slotsize="0" data-eventID="$ID"><strong>An diesem Tag sind keine freien Zeitslots mehr verfügbar</strong><br>Komme gerne trotzdem vorbei und stelle dich in die reguläre Warteschlange oder versuche es später erneut. Es melden sich immer mal wieder auch Leute ab oder wir schalten neue Plätze frei.</p>
                                    <% loop $FullTimeSlots %>
                                        <div class="timeslot_card timeslot_card--full" data-behaviour="timeslot" data-slotId="$ID" data-slotsize="0" data-eventID="$Parent.ID">
                                            <p class="timeslot_card_time">$SlotTimeFormatted</p>
                                            <p class="timeslot_card_capacity">Ausgebucht!</p>
                                        </div>
                                    <% end_loop %>
                                <% end_if %>

                                <% if $FreeCouponTimeSlotsInFuture.Count > 0 %>
                                    <% loop $FreeCouponTimeSlotsInFuture %>
                                        <div class="timeslot_card" data-behaviour="coupontimeslot" data-slotId="$ID" data-slotsize="$getFreeCouponSlotCount" data-eventID="$Parent.ID">
                                            <p class="timeslot_card_time">$SlotTimeFormatted</p>
                                            <p class="timeslot_card_capacity">$CouponAttendeesFormatted</p>
                                        </div>
                                    <% end_loop %>
                                    <% loop $FullCouponTimeSlots %>
                                        <div class="timeslot_card timeslot_card--full" data-behaviour="coupontimeslot" data-slotId="$ID" data-slotsize="0" data-eventID="$Parent.ID">
                                            <p class="timeslot_card_time">$SlotTimeFormatted</p>
                                            <p class="timeslot_card_capacity">Ausgebucht!</p>
                                        </div>
                                    <% end_loop %>
                                <% else %>
                                    <p class="timeslot_card timeslot_card--text" data-behaviour="coupontimeslot" data-slotsize="0" data-eventID="$ID">Keine freien Zeitslots an diesem Tag verfügbar.</p>
                                <% end_if %>
                            <% end_loop %>
                        <% end_loop %>
                    </div>
                </div>

                <div class="events_navigator_step groupsize hidden" data-eventstep="4">
                    <h2>4. Gruppengröße wählen</h2>
                    <div class="section_selectablelist">
                        <a class="groupsize_button" data-behaviour="groupsize-button" data-groupsize="1">1 Person</a>
                        <a class="groupsize_button" data-behaviour="groupsize-button" data-groupsize="2">2 Personen</a>
                        <a class="groupsize_button" data-behaviour="groupsize-button" data-groupsize="3">3 Personen</a>
                        <a class="groupsize_button" data-behaviour="groupsize-button" data-groupsize="4">4 Personen</a>
                        <a class="groupsize_button" data-behaviour="groupsize-button" data-groupsize="5">5 Personen</a>
                    </div>
                </div>

                <div class="events_navigator_step form hidden" data-eventstep="5">
                    <h2>5. Anmelden</h2>
                    $RegistrationForm
                </div>
            </div>
        <% else %>
            <p>Es sind keine Veranstaltungen verfügbar.</p>
        <% end_if %>
    </div>
</div>
