<?php

class Pyz_Zed_Calculation_Component_Model_Calculators_ShippingCosts extends ProjectA_Zed_Calculation_Component_Model_Calculators_Abstract implements ProjectA_Zed_Calculation_Component_Interface_Calculator
{

    /**
     * @var bool
     */
    public $modifyTotals = true;

    /**
     * @param ProjectA\Shared\Sales\Transfer\Order $order
     */
    public function recalculate(ProjectA\Shared\Sales\Transfer\Order $order)
    {
        parent::recalculate($order);

        $shippingCosts = $this->getAmount($order);
        $this->setTotals($shippingCosts, $order);
    }

    /**
     * @param Pyz_Shared_Sales_Transfer_Order|ProjectA_Zed_Sales_Persistence_PacSalesOrder $order
     * @return mixed
     */
    public function getAmount($order)
    {
        $shippingCosts = 0;

        // Item expenses
        foreach ($order->getItems() as $item) {
            foreach ($item->getExpenses() as $expense) {
                if ($expense->getType() === ProjectA_Shared_Library_Sales_ExpenseConstants::EXPENSE_SHIPPING) {
                    $shippingCosts += $expense->getPriceToPay();
                }
            }
        }

        // order expenses
        foreach ($order->getExpenses() as $expense) {
            if ($expense->getType() === ProjectA_Shared_Library_Sales_ExpenseConstants::EXPENSE_SHIPPING) {
                $shippingCosts += $expense->getPriceToPay();
            }
        }

        return $shippingCosts;
    }

    /**
     * @param int $amount
     * @param Pyz_Shared_Sales_Transfer_Order|ProjectA_Zed_Sales_Persistence_PacSalesOrder $order
     */
    public function setTotals($amount, $order)
    {
        $totals = $order->getTotals();
        $totals->setShippingCosts($amount);
        $order->setTotals($totals);
    }

}
