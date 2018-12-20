<template>
  <div>
    <!-- 表单 -->
    <el-form :inline="true" :model="form1" style="margin-top: 20px;" align="left">

      <el-form-item label="一级菜单:">
        <el-select v-model="form1.selectOneLvMenu" placeholder="全部">
          <el-option
            v-for="item in form1.optionsOneLvMenu"
            :key="item.value"
            :label="item.label"
            :value="item.value"
          />
        </el-select>
      </el-form-item>

      <el-form-item label="二级菜单:">
        <el-select v-model="form1.selectTwoLvMenu" placeholder="全部">
          <el-option
            v-for="item in form1.optionsTwoLvMenu"
            :key="item.value"
            :label="item.label"
            :value="item.value"
          />
        </el-select>
      </el-form-item>

      <el-form-item label="操作时间:">
        <el-date-picker
          v-model="form1.date"
          type="daterange"
          range-separator="~"
          start-placeholder="开始日期"
          end-placeholder="结束日期"/>
      </el-form-item>

      <el-form-item label="操作人">
        <el-input v-model="form1.operation" placeholder="操作人"/>
      </el-form-item>

      <el-form-item>
        <el-button type="primary" icon="el-icon-search" @click="onSubmit">搜索</el-button>
      </el-form-item>

    </el-form>

    <!-- table -->
    <el-table
      :data="tableData"
      :default-sort="{prop: 'timeBegin', order:'descending'}"
      style="width: 100%; margin-bottom: 24px">
      <el-table-column prop="oneLvMenu" label="一级菜单" align="center"/>
      <el-table-column prop="twoLvMenu" label="二级菜单" align="center"/>
      <el-table-column prop="content" label="内容" align="center"/>
      <el-table-column prop="operateTime" label="操作时间" align="center"/>
      <el-table-column prop="operator" label="操作人" align="center"/>
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

  </div>
</template>

<script>

export default {
  data() {
    return {

      form1: {
        selectOneLvMenu: '',
        optionsOneLvMenu: [{
          label: '首页',
          value: 'homePage'
        }, {
          label: '会员管理',
          value: 'vip'
        }, {
          label: '游戏管理',
          value: 'game'
        }, {
          label: '财务管理',
          value: 'finance'
        }, {
          label: '公告管理',
          value: 'announce'
        }, {
          label: '推广管理',
          value: 'promotion'
        }, {
          label: '系统设置',
          value: 'system'
        }, {
          label: '运营管理',
          value: 'operation'
        }, {
          label: '活动管理',
          value: 'activity'
        }, {
          label: '网站管理',
          value: 'website'
        }],

        selectTwoLvMenu: '',
        optionsTwoLvMenu: [{
          label: '全部',
          value: 'all'
        }],

        date: '',
        operator: ''
      },

      // tableData
      tableData: [{
        oneLvMenu: '2018-11-11 11:11:11',
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
