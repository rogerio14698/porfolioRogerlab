/**
 * Archivo: resources/js/dior-and-services.ts
 * Descripción: Comportamiento interactivo en TypeScript para la landing Dior split-screen
 * y la tienda de servicios freelance (preselección de servicios y planes en el formulario).
 */

export function initDiorAndServices(): void {
    // 1. Interacción táctil y teclado para los paneles split Dior
    const panelPortfolio = document.getElementById('panelPortfolio');
    const panelFreelance = document.getElementById('panelFreelance');

    if (panelPortfolio && panelFreelance) {
        // Soporte de navegación por teclado accesible
        [panelPortfolio, panelFreelance].forEach((panel) => {
            panel.addEventListener('keydown', (e: KeyboardEvent) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    const link = panel.querySelector<HTMLAnchorElement>('.dior-btn');
                    if (link) {
                        e.preventDefault();
                        link.click();
                    }
                }
            });
        });
    }

    // 2. Preselección automática de servicio al pulsar 'Elegir este servicio'
    const serviceButtons = document.querySelectorAll<HTMLAnchorElement>('[data-select-service]');
    const serviceSelect = document.getElementById('service_select') as HTMLSelectElement | null;
    const clientDesc = document.getElementById('client_description') as HTMLTextAreaElement | null;

    serviceButtons.forEach((btn) => {
        btn.addEventListener('click', (e) => {
            const chosenService = btn.getAttribute('data-select-service');
            if (serviceSelect && chosenService) {
                // Buscar si existe coincidencia exacta o parecida en las opciones
                for (let i = 0; i < serviceSelect.options.length; i++) {
                    if (serviceSelect.options[i].text.toLowerCase().includes(chosenService.toLowerCase())) {
                        serviceSelect.selectedIndex = i;
                        break;
                    }
                }
                if (clientDesc && clientDesc.value.trim() === '') {
                    clientDesc.value = `Hola Rogerio, estoy interesado en el servicio de "${chosenService}". `;
                    clientDesc.focus();
                }
            }
        });
    });

    // 3. Preselección automática de plan (pago único, mensual o bolsa de horas)
    const planButtons = document.querySelectorAll<HTMLAnchorElement>('[data-select-plan]');
    const planSelect = document.getElementById('plan_select') as HTMLSelectElement | null;

    planButtons.forEach((btn) => {
        btn.addEventListener('click', () => {
            const chosenPlan = btn.getAttribute('data-select-plan');
            if (planSelect && chosenPlan) {
                for (let i = 0; i < planSelect.options.length; i++) {
                    if (planSelect.options[i].text.toLowerCase().includes(chosenPlan.toLowerCase())) {
                        planSelect.selectedIndex = i;
                        break;
                    }
                }
            }
        });
    });

    // 4. Preselección de diagnóstico para webs existentes
    const prefillButtons = document.querySelectorAll<HTMLAnchorElement>('[data-prefill-service]');
    prefillButtons.forEach((btn) => {
        btn.addEventListener('click', () => {
            const prefill = btn.getAttribute('data-prefill-service');
            if (clientDesc && prefill) {
                clientDesc.value = `Hola Rogerio, me gustaría solicitar una auditoría o diagnóstico técnico para mi sitio web existente. `;
                const websiteInput = document.getElementById('client_website') as HTMLInputElement | null;
                if (websiteInput) {
                    websiteInput.focus();
                }
            }
        });
    });
}

// Inicializar al cargar el DOM y en navegaciones parciales
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initDiorAndServices);
} else {
    initDiorAndServices();
}

window.addEventListener('section-loaded', initDiorAndServices);
