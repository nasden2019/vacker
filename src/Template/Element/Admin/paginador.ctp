<nav aria-label="Page navigation">
    <ul class="pagination align-items-center justify-content-center">
        <?php
        	echo $this->Paginator->first(__('Inicio'));
            echo $this->Paginator->prev(__('«'));
            echo $this->Paginator->numbers();
            echo $this->Paginator->next(__('»'));
            echo $this->Paginator->last(__('Ult Pág'));
         ?>
    </ul>
</nav>