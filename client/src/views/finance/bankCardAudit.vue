<template>

  <div>
    <el-container>
      <el-main>

        <!-- 表单 -->
        <el-form :model="form1" style="margin-bottom: 10px; margin-top: 20px;" label-position="right" label-width="100px">
          <el-row :gutter="20">
            <el-col :span="6"><el-form-item label="订单号"><el-input placeholder="订单号"/></el-form-item></el-col>
            <el-col :span="6"><el-form-item label="会员账号"><el-input placeholder="会员账号"/></el-form-item></el-col>
            <el-col :span="6">
              <el-form-item label="会员等级">
                <el-select v-model="form1.vipLv" placeholder="请选择">
                  <el-option
                    v-for="item in optionsVipLv"
                    :key="item.value"
                    :label="item.label"
                    :value="item.value"
                  />
                </el-select>
              </el-form-item>
            </el-col>
            <el-col :span="6">
              <el-form-item label="订单状态">
                <el-select v-model="form1.orderStatus" placeholder="请选择">
                  <el-option
                    v-for="item in optionsOrderStatus"
                    :key="item.value"
                    :label="item.label"
                    :value="item.value"
                  />
                </el-select>
              </el-form-item>
            </el-col>
          </el-row>

          <el-row :gutter="20">
            <el-col :span="6"><el-form-item label="会员ID"><el-input placeholder="会员ID"/></el-form-item></el-col>
            <el-col :span="6"><el-form-item label="操作人"><el-input placeholder="操作人"/></el-form-item></el-col>
            <el-col :span="8">
              <!-- <el-row> -->
              <el-col :span="6"><el-form-item label="金额"><el-input style="width:100px" placeholder="最低金额"/></el-form-item></el-col>
              <el-col :span="6"><el-form-item label="~"><el-input style="width:100px" placeholder="最高金额"/></el-form-item></el-col>
              <!-- </el-row> -->
            </el-col>
            <el-col :span="4"><el-form-item><el-button type="primary" icon="el-icon-search" @click="onSubmit">查询</el-button></el-form-item></el-col>
          </el-row>
          <el-form-item label="申请日期">
            <el-date-picker
              v-model="dpValue1"
              type="daterange"
              range-separator="~"
              start-placeholder="开始日期"
              end-placeholder="结束日期"
            />
          </el-form-item>
        </el-form>

        <!-- 表格 -->
        <el-table
          :data="tableData"
          :default-sort="{prop: 'timeBegin', order:'descending'}"
          stripe="true"
          style="width: 100%; margin-bottom: 20px">
          <el-table-column prop="vipAccount" label="会员账号" align="center"/>
          <el-table-column prop="vipId" label="会员ID" align="center"/>
          <el-table-column prop="orderId" label="订单编号" align="center"/>
          <el-table-column prop="bankCardAccount" label="银行卡账号" align="center"/>
          <el-table-column prop="paymentAmount" label="出款金额" align="center"/>
          <el-table-column prop="paymentAmountActual" label="实际出款金额" align="center"/>
          <el-table-column prop="cost" label="费用扣除" align="center"/>
          <el-table-column prop="applyTime" label="申请时间" align="center"/>
          <el-table-column prop="paymentStatus" label="出款状态" align="center"/>
          <el-table-column prop="lockStatus" label="锁定状态" align="center"/>
          <el-table-column prop="operator" label="操作人" align="center"/>
          <el-table-column prop="operation" label="操作" align="center"/>
        </el-table>

        <!-- 分页 -->
        <el-pagination
          :current-page="currentPage"
          :page-sizes="[10, 20, 30, 40]"
          :page-size="10"
          :total="40"
          layout="total, sizes, prev, pager, next, jumper"
          align="center"
          @size-change="handleSizeChange"
          @current-change="handleCurrentChange"
        />
      </el-main>
    </el-container>
  </div>
</template>

<script>
export default {
  data() {
    return {
      // 日期(不在这里返回会不显示选择的时间)
      dpValue1: '',

      form1: {
      },

      // orderStatus
      optionsOrderStatus: [{
        'label': '申请中',
        'value': 'applying'
      }, {
        'label': '已出款',
        'value': 'paymentOut'
      }, {
        'label': '已拒绝',
        'value': 'rejected'
      }, {
        'label': '出款失败',
        'value': 'paymentFail'
      }],

      // tableData
      tableData: [{
        timeBegin: '2018-11-11 11:11:11',
        timeEnd: '2018-11-11 11:11:11',
        vipAccount: 'ok1',
        gameName: '牛牛1',
        gameRoom: '初级房',
        bet: 11.11,
        winAmount: 11.11,
        winLose: 11.11,
        tax: 11.11
      }, {
        timeBegin: '2018-11-11 11:11:12',
        timeEnd: '2018-11-11 11:11:12',
        vipAccount: 'ok2',
        gameName: '牛牛2',
        gameRoom: '初级房',
        bet: 11.12,
        winAmount: 11.12,
        winLose: 11.12,
        tax: 11.12
      }],

      // 分页
      currentPage: 4
    }
  },
  methods: {
    obSubmit() {
      console.log('submit!')
    },

    // 分页
    handleSizeChange(val) {

    },
    handleCurrentChange(val) {

    }
  }
}
</script>
