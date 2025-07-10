<div class="menu-suggestions disabled body-title" data-menu="suggestions">
    <div class="pill-container">
        <div class="drag-handle"></div>
    </div>
    <form id="suggestion-form" action="api/submit-suggestion.php" method="POST" novalidate>
        <div class="menu-section">
            <div class="menu-section-top">
                <div class="menu-header-fixed">
                    <button class="menu-back-btn" type="button" data-action="back-to-previous-menu">
                        <span class="material-symbols-rounded">arrow_left</span>
                    </button>
                    <div class="menu-content-header">
                        <div class="menu-content-header-primary">
                            <span class="material-symbols-rounded">emoji_objects</span>
                            <span data-translate="suggest_improvements_title" data-translate-category="menu"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="menu-content-scrolleable overflow-y">
                <div class="creation-wrapper">
                <div class="menu-section-center">
                    <div class="menu-content-wrapper active">
                          <div class="menu-content">
                            <div class="menu-content-header">
                                <div class="menu-content-header-primary">
                                    <span class="material-symbols-rounded">email</span>
                                    <span>Correo Electrónico</span> </div>
                            </div>
                            <div class="menu-content-general">
                                <div class="enter-text-tool">
                                     <input type="email" id="suggestion-email" name="email" placeholder="tucorreo@ejemplo.com" required>
                                </div>
                            </div>
                        </div>
                        <div class="menu-content">
                            <div class="menu-content-header">
                                <div class="menu-content-header-primary">
                                    <span class="material-symbols-rounded">rule</span>
                                    <span data-translate="suggestion_type" data-translate-category="menu"></span>
                                </div>
                            </div>
                            <div class="menu-content-general">
                                <input type="hidden" name="suggestion_type" id="suggestion-type-value" value="improvement">
                                <div class="custom-select-content" data-action="open-suggestion-types-menu" role="button" tabindex="0">
                                    <div class="custom-select-content-left">
                                        <span id="suggestion-type-display" data-translate="suggestion_type_improvement" data-translate-category="menu"></span>
                                    </div>
                                    <div class="custom-select-content-right">
                                        <span class="material-symbols-rounded">arrow_right</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="menu-content">
                            <div class="menu-content-header">
                                <div class="menu-content-header-primary">
                                    <span class="material-symbols-rounded">inbox</span>
                                    <span data-translate="write_suggestion_message" data-translate-category="menu"></span>
                                </div>
                            </div>
                            <div class="menu-content-general">
                                <textarea class="suggestion-text overflow-y" id="suggestion-text" name="suggestion_text" rows="5" required></textarea>
                            </div>
                        </div>

                      

                    </div>
                </div>
                </div>
            </div>
            <div class="menu-section-bottom">
                <div class="menu-button-group">
                    <button type="button" class="menu-button" data-action="cancel-suggestion" data-translate="cancel" data-translate-category="confirmation"></button>
                    <button type="submit" class="menu-button menu-button--primary">
                        <span data-translate="send_suggestion" data-translate-category="menu"></span>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>