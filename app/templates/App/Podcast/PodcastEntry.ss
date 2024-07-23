<% with $Episode %>
    <h1>$Title</h1>
    <p>$Description</p>
    <audio controls>
        <source src="$Audio.AbsoluteLink" type="audio/$Audio.getExtension" />
        Your browser does not support the audio element.
    </audio>
<% end_with %>
