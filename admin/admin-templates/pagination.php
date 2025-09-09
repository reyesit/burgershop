<?php
    // Note, $pagination variable comes from the main page, where this is imported

    $maxPageCount = (int) ceil($pagination['totalRowCount'] / $pagination['limit']);
?>

<!-- Pagination -->
<div class="d-flex justify-content-between align-items-center">

    <!-- Page Limit -->
    <div class="d-flex align-items-center">
        <span>Show</span>
        <select id="paginationSelect" class="form-select form-select-sm w-auto mx-2" aria-label="Default select">
            <option value="10" <?php if( (int)$pagination['limit'] === 10 ) echo 'selected'; ?>>10</option>
            <option value="15" <?php if( (int)$pagination['limit'] === 15 ) echo 'selected'; ?>>15</option>
            <option value="20" <?php if( (int)$pagination['limit'] === 20 ) echo 'selected'; ?>>20</option>
        </select>
        <span>rows per page</span>
    </div>

    <!-- Page Number -->
    <nav aria-label="Page navigation">
        <ul class="pagination align-items-center m-0">

            <!-- Previous -->
            <li class="page-item <?php if((int)$pagination['page'] === 1) echo 'disabled'?>">
                <a class="page-link" href="#" onclick="goToPage(<?= (int)$pagination['page'] - 1 ?>)"> <!-- this is for JavaScript function na magpupunta sa previous page -->
                    <span aria-hidden="true">&laquo;</span> <!-- &laquo; - « (left-pointing double angle quotation mark) -->
                </a>
            </li>
            
            <!-- Jump Start -->
            <!-- Kapag hindi nasa page 1 ang user, lalabas ang link na may number 1 para mabilis siyang makabalik sa first page tas gumawa tayo ng JS function don which is goToPage() -->
            <?php if( (int)$pagination['page'] !== 1) { // If current page is not page 1 ?>
                <li class="page-item"><a class="page-link" href="#" onclick="goToPage(1)">1</a></li> 
                <!-- If current page is not next to 1 or malayo na yung current page, display "..." bilang indicator na may mga pages sa pagitan. -->
                <?php if( (int)$pagination['page'] !== 2) { ?>
                    <li class="page-item disabled"><a class="page-link">...</a></li>
                <?php } ?>
            <?php } ?>

            <li class="page-item">
                <a class="page-link p-1 rounded-1">
                    <form id="paginationForm">
                        <div class="input-group">
                            <!-- eto naman is yung sa input page number ni user na bawal bumaba sa 1 ang min and maximum is set to $maxPageCount to control the input based on available pages -->
                            <input id="paginationGoToPageInput" type="number" class="form-control" value="<?= $pagination['page'] ?>" min="1" max="<?= $maxPageCount ?>">
                            <!-- Eto naman ang GO button na pinipindot kapag may nilagay na page number si user para lumipat sa page na yun -->
                            <button class="btn btn-secondary" type="submit">GO</button>
                        </div>
                    </form>
                </a>
            </li>
            

            <!-- Jump End -->
            <!-- If current page is not max, the maxPageCount will see in the side so, the user will click it nalang agad -->
            <?php if( (int)$pagination['page'] !== $maxPageCount) { ?>
                <!--If current page is not previous to $maxPageCount, display "..." like 10 ang maxpage tas nasa 6 ka lalabas yung '...' indicates that may numbers na nasa pagitan pa' -->
                <?php if( (int)$pagination['page'] !== $maxPageCount - 1) { ?> 
                    <li class="page-item disabled"><a class="page-link">...</a></li>
                <?php } ?>
                
                <!-- Need lang i-click ng user ang number ng max page para mapunta agad sa last page -->
                    <li class="page-item"><a class="page-link" href="#" onclick="goToPage(<?= $maxPageCount ?>)"><?= $maxPageCount ?></a></li> 

            <?php } ?> 

            <!-- Next -->
            <!-- eto nag plus 1 lang tayo sa current page para kapag click ni user mapupunta sya sa next page. Kapag nasa last page na, naka-disable ang button para hindi makapag-next. -->
            <li class="page-item <?php if((int)$pagination['page'] === $maxPageCount) echo 'disabled'?>">
                <a class="page-link" href="#" onclick="goToPage(<?= (int)$pagination['page'] + 1 ?>)">
                    <span aria-hidden="true">&raquo;</span> <!-- &raquo; = » (right double angle quote) -->
                </a>
            </li>
        </ul>
    </nav>
</div>

<script>
    const urlParams = new URLSearchParams(window.location.search);

    /* 
    Pagination onChange, reload page with new limit
    Pagination onChange: kapag nagpalit si user ng bilang ng items per page (limit),
    Iri-reload ang page at iseset ang bagong limit sa URL para ma-apply ang pagbabago.
    */
    const paginationLimit = document.querySelector('#paginationSelect');
    paginationLimit.addEventListener('change', (event) => {
        urlParams.set('limit', event.target.value);
        const newUrl = `${window.location.pathname}?${urlParams.toString()}`;
        window.location.assign(newUrl);
    });


    /*
    Reload the current page, with the new page as param
    Reload the page with the updated 'page' query parameter, so the server loads the specified page.
    */
    function goToPage(pageNumber) {
        urlParams.set('page', pageNumber);
        const newUrl = `${window.location.pathname}?${urlParams.toString()}`;
        window.location.assign(newUrl);
    }

    // Go button - Event listender for pagination form, when "Go" button is clicked
    document.querySelector('#paginationForm').addEventListener('submit', function(event) {
        event.preventDefault(); // To prevent the form from submitting agad-agad, need muna kunin yung sinet ni user para gumana ng maayos yung pagination
        const paginationGoToPageInput = document.querySelector('#paginationGoToPageInput');
        goToPage(paginationGoToPageInput.value);
    })
</script>