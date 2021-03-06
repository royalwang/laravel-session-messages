@if(tlsm_messages()->count() > 0)
<div id="messages">
    @foreach(tlsm_messages() as $Message)
    <?php /* @var $Message \Tarach\LSM\Message\Message */ ?>
    <div data-message-index="{{$Message->getIndex()}}" class="{{ $Message->getClasses() }}">
        {{ $Message->getMessage() }}
        <a href="#" class="close"><span>&times;</span></a>
    </div>
        @if($Message->getMethod() == \Tarach\LSM\Message\Message::METHOD_FLASH)
            <?php $Message->remove(); ?>
        @endif
    @endforeach
</div>
@endif