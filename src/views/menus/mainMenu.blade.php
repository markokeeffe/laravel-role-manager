@foreach( $menu as $item )
  @if( is_array($item['link']) )
    <li class="dropdown">
      <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown"> {{ $item['title'] }} <b class="caret"></b></a>
      <ul class="dropdown-menu">
        @foreach( $item['link'] as $subItem )
        <li {{ (Request::is($subItem['link'].'*') ? ' class="active"' : '') }}>
          {{ link_to(
            $subItem['link'],
            $subItem['title'],
            (isset($subItem['options']) ? $subItem['options'] : array())
          ) }}
        </li>
        @endforeach
      </ul>
    </li>
  @else
    <li{{ (Request::is($item['link'].'*') ? ' class="active"' : '') }}>
      {{ link_to(
        $item['link'],
        $item['title'],
        (isset($item['options']) ? $item['options'] : array())
      ) }}
    </li>
  @endif
@endforeach