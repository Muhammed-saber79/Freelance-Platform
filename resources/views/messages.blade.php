<x-app-layout>
    <!-- Dashboard Content -->
    <div class="messages-container margin-top-0">
        <div class="messages-container-inner">

            <!-- Messages -->
            <div class="messages-inbox">
                <div class="messages-headline">
                    <div class="input-with-icon">
                            <input id="autocomplete-input" type="text" placeholder="Search">
                        <i class="icon-material-outline-search"></i>
                    </div>
                </div>

                <ul>
                    <li class="active-message">
                        <a href="#">
                            <div class="message-avatar">
                                <i class="status-icon status-online"></i>
                                <img src="{{ $receiver->profile_photo_url }}" alt="" />
                            </div>

                            <div class="message-by">
                                <div class="message-by-headline">
                                    <h5>{{ $receiver->name }}</h5>
                                    <span>4 hours ago</span>
                                </div>
                                <p>Thanks for reaching out. I'm quite busy right now on many</p>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- Messages / End -->

            <!-- Message Content -->
            <div class="message-content">
                <div class="messages-headline">
                    <h4>{{ $receiver->name }}</h4>
                    <a href="#" class="message-action"><i class="icon-feather-trash-2"></i> Delete Conversation</a>
                </div>

                <!-- Message Content Inner -->
                <div id="messagesList" class="message-content-inner">
                    <!-- Time Sign -->
                    <div class="message-time-sign">
                        <span>28 June, 2018</span>
                    </div>

                    <div class="message-bubble me">
                        <div class="message-bubble-inner">
                            <div class="message-avatar"><img src="{{ $sender->profile_photo_url }}" alt="" /></div>
                            <div class="message-text"><p>Thanks for choosing my offer. I will start working on your project tomorrow.</p></div>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="message-bubble">
                        <div class="message-bubble-inner">
                            <div class="message-avatar"><img src="{{ $receiver->profile_photo_url }}" alt="" /></div>
                            <div class="message-text"><p>Great. If you need any further clarification let me know. 👍</p></div>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="message-bubble me">
                        <div class="message-bubble-inner">
                            <div class="message-avatar"><img src="{{ $sender->profile_photo_url }}" alt="" /></div>
                            <div class="message-text"><p>Ok, I will. 😉</p></div>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <!-- Time Sign -->
                    <div class="message-time-sign">
                        <span>Yesterday</span>
                    </div>

                    <div class="message-bubble me">
                        <div class="message-bubble-inner">
                            <div class="message-avatar"><img src="{{ $sender->profile_photo_url }}" alt="" /></div>
                            <div class="message-text"><p>Hi Sindy, I just wanted to let you know that project is finished and I'm waiting for your approval.</p></div>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="message-bubble">
                        <div class="message-bubble-inner">
                            <div class="message-avatar"><img src="{{ $receiver->profile_photo_url }}" alt="" /></div>
                            <div class="message-text"><p>Hi Tom! Hate to break it to you, but I'm actually on vacation 🌴 until Sunday so I can't check it now. 😎</p></div>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="message-bubble me">
                        <div class="message-bubble-inner">
                            <div class="message-avatar"><img src="{{ $sender->profile_photo_url }}" alt="" /></div>
                            <div class="message-text"><p>Ok, no problem. But don't forget about last payment. 🙂</p></div>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="message-bubble">
                        <div class="message-bubble-inner">
                            <div class="message-avatar"><img src="{{ $receiver->profile_photo_url }}" alt="" /></div>
                            <div class="message-text">
                                <!-- Typing Indicator -->
                                <div class="typing-indicator">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <!-- Message Content Inner / End -->

                <!-- Reply Area -->
                <form id="messageForm" action="{{ route('messages') }}">
                    <div class="message-reply">
                        <input type="hidden" name="_token" id="csrf" value="{{ csrf_token() }}">
                        <input type="hidden" id="receiver_id" name="receiver_id" value="13">
                        <textarea cols="1" rows="1" id="message" name="message" placeholder="Your Message" data-autoresize></textarea>
                        <button class="button ripple-effect">Send</button>
                    </div>
                </form>

                <script>
                    var form = document.getElementById('messageForm');
            
                    form.addEventListener('submit', (event) => {
                        event.preventDefault();

                        let url = $('#messageForm').attr('action');
                        let csrf = $('#csrf').val();
                        let formData = {
                            'receiver_id': $('#receiver_id').val(),
                            'message': $('#message').val(),
                        }

                        $.ajax({
                            url: url,
                            headers: {
                                'X-CSRF-TOKEN': csrf
                            },
                            method: 'POST',
                            data: formData,
                            success: function(response) {
                                let messagesList = $('#messagesList');

                                let newMessage = `
                                    <div class="message-bubble me">
                                        <div class="message-bubble-inner">
                                            <div class="message-avatar"><img src="{{ $sender->profile_photo_url }}" alt="" /></div>
                                            <div class="message-text">
                                                <p>${response.message}</p>
                                                <small style='color: yellow'>${formatTimestamp(response.created_at)} </small>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                `;

                                function formatTimestamp(timestamp) {
                                    const date = new Date(timestamp);
                                    const options = { year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric', second: 'numeric' };
                                    return date.toLocaleDateString(undefined, options);
                                }


                                messagesList.append(newMessage);
                                messagesList.scrollTop(messagesList[0].scrollHeight);
                            },
                            error: function(xhr, status, error) {
                                console.error("Error: " + status, error);
                            }
                        });

                        return false; // Add this line to prevent form submission
                    });
                </script>
            </div>
            <!-- Message Content -->
        </div>
        <!-- Messages Container / End -->
    </div>
</x-app-layout>
