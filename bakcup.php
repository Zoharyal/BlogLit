  {% set next = chapter.getNextId() %}
            {% set prev = chapter.getPrevId() %}
        <a href="{{path('chapter', {id: next}) }}" class="chapterTitle"><h3 class="title">Chapitre suivant</h3></a>
        <a href="{{path('chapter', {id: prev}) }}" class="chapterTitle"><h3 class="title">Chapitre précedent</h3></a>