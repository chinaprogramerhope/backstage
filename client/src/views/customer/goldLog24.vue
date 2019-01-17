<template>
  <div>
    <el-form
      :inline="true"
      :model="form1"
      align="left"
      style="margin-left: 10px; margin-top: 30px;"
      label-position="right"
      label-width="100px">

      <el-form-item label="用户id">
        <el-input v-model="form1.userId" placeholder="用户id"/>
      </el-form-item>

      <el-form-item label="">
        <el-button type="primary" size="small" @click="handleReset()">重置</el-button>
      </el-form-item>

      <el-form-item label="">
        <el-button type="primary" size="small" icon="el-icon-search" @click="handleGet()">查询</el-button>
      </el-form-item>

    </el-form>

    <!-- 表格1 -->
    <el-table
      :data="tableData"
      :default-sort="{prop: 'id', order:'descending'}"
      stripe
      style="width: 100%; margin-bottom: 20px">
      <el-table-column min-width="10%" prop="id" label="金豆变化" align="center"/>
      <el-table-column min-width="10%" prop="gold" label="时间" align="center"/>
    </el-table>

  </div>
</template>

<script>
export default {
  data() {
    return {
      form1: {
        selectGame: -1,
        optionsGame: [{
          label: '全部',
          value: -1
        }],

        selectWay: -1,
        optionsWay: [{
          label: '全部',
          value: -1
        }],

        userId: '',
        accuont: '',
        dateTimeRange: ''
      },

      tableData: [{
        id: '11'
      }],

      tableDataSum: ''
    }
  },

  created() {

  },

  methods: {

    // 添加游戏版本
    handleAdd() {

    }
  }
}
</script>
