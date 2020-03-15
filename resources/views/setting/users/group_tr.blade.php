<tr id="group_id_{{$group->id}}" data-id="{{$group->id}}">

    <td>


        <span class="user-group">
                    <img src="/global_assets/images/icon/user/group.svg">
                    <span class="group_count_{{$group->id}}">@if($group->users) {{$group->users->count()}} @else 0 @endif</span>
                    </span><span class="user-name">{{$group->name}}</span></td>
    <td class="count-user group_count_{{$group->id}}">@if($group->users) {{$group->users->count()}} @else 0 @endif</td>
    <td class="selected-user select-conainer-icon-multi select-conainer-group-multi"><div class="form-group"><select data-placeholder="+ Добавить пользователя" class="select-icons select-group-user form groups" multiple="multiple"  style="width:100%" name="state">
            @foreach($stages as $st)
                    <option value="{{$st->id}}" @if($st->groups->where('id',$group->id)->first()) selected @endif ><span class="user-avatar" data-group="{{$group->id}}"  data-user="{{$st->id}}"><img src="/global_assets/images/icon/user/user.svg"></span><span class="user-name">{{$st->name}} </span></option>
            @endforeach
        </select></div></td>
    <td class="text-center"><a class="edit-user"><img class="user-btn" src="/global_assets/images/icon/user/edit.svg"></a></td>
    <td class="text-center"><a href="#" data-id="{{$group->id}}" data-url="/setting/usersgroup/{{$group->id}}"  class="deletefrom" ><img class="user-btn" src="/global_assets/images/icon/user/trash.svg"></a>
    </td>
</tr>


			