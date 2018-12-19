<template>
  <div>
    <!-- tabs 标签页 -->
    <el-tabs type="border-card" style="margin-top: 20px;">
      <el-tab-pane label="收件箱">1</el-tab-pane>
      <el-tab-pane label="发件箱">1</el-tab-pane>
    </el-tabs>

    <!-- 表单 -->
    <el-form :inline="true" :model="form1" style="margin-top: 20px;" align="left">
      <el-form-item label="公告类型:">
        <el-select>
          <el-option
            v-for="item in form1.optionsAnnounceType"
            :key="item.value"
            :label="item.label"
            :value="item.value"
          />
        </el-select>
      </el-form-item>
      <el-form-item label="开始时间:">
        <el-date-picker
          v-model="dpValue1"
          type="datetimerange"
          range-separator="~"
          start-placeholder="开始日期"
          end-placeholder="结束日期"/>
      </el-form-item>
      <el-form-item>
        <el-button type="primary" icon="el-icon-search" @click="onSubmit">搜索</el-button>
      </el-form-item>

      <el-form-item>
        <el-button @click="dialogFormVisible = true">+ 添加</el-button>
      </el-form-item>
    </el-form>

    <!-- dialog 添加公告 -->
    <el-dialog :visible.sync="dialogFormVisible" title="添加公告" center>
      <el-form :model="form2">
        <el-form-item :label-width="formLabelWidth" label="公告内容:">
          <el-input
            :rows="2"
            v-model="form2.content"
            type="textarea"
            placeholder="请输入公告内容"/>
        </el-form-item>

        <el-form-item :label-width="formLabelWidth" label="备注:">
          <el-input v-model="form2.note" autocomplete="off"/>
        </el-form-item>

        <el-form-item :label-width="formLabelWidth" label="公告类型">
          <el-select v-model="form2.selectType" placeholder="">
            <el-option
              v-for="item in form2.optionsAnnounceAddType"
              :key="item.value"
              :label="item.label"
              :value="item.value"
            />
          </el-select>
        </el-form-item>

        <el-form-item :label-width="formLabelWidth" label="公告状态">
          <el-select v-model="form2.selectStatus" placeholder="">
            <el-option
              v-for="item in form2.optionsAnnounceAddStatus"
              :key="item.value"
              :label="item.label"
              :value="item.value"
            />
          </el-select>
        </el-form-item>

        <el-form-item :label-width="formLabelWidth" label="发送区域">
          <el-checkbox :indeterminate="isIndeterminate" v-model="checkAll" @change="handleCheckAllChange">全选</el-checkbox>
          <div style="margin: 15px 0;"/>
          <el-checkbox-group v-model="checkedAreas" @change="handleCheckedAreaChange">
            <el-checkbox v-for="area in areas" :label="area" :key="area">{{ area }}</el-checkbox>
          </el-checkbox-group>
        </el-form-item>

        <el-form-item :label-width="formLabelWidth" label="使用终端">
          <el-select v-model="form2.selectTerminal" placeholder="">
            <el-option
              v-for="item in form2.optionsAnnounceAddTerminal"
              :key="item.value"
              :label="item.label"
              :value="item.value"
            />
          </el-select>
        </el-form-item>
      </el-form>

      <div slot="footer" class="dialog-footer">
        <el-button @click="dialogFormVisible = false">取 消</el-button>
        <el-button type="primary" @click="dialogFormVisible = false">保 存</el-button>
      </div>
    </el-dialog>

    <!-- table -->
    <el-table
      :data="tableData"
      :default-sort="{prop: 'timeBegin', order:'descending'}"
      style="width: 100%; margin-bottom: 24px">
      <el-table-column prop="id" label="序号" align="center"/>
      <el-table-column prop="type" label="类型" align="center"/>
      <el-table-column prop="content" label="公告内容" align="center"/>
      <el-table-column prop="publishTime" label="发布时间" align="center"/>
      <el-table-column prop="status" label="公告状态" align="center"/>
      <el-table-column prop="creater" label="创建人" align="center"/>
      <el-table-column prop="note" label="备注" align="center"/>
      <el-table-column prop="operation" label="操作" align="center">
        <template slot-scope="scope">
          <el-button type="primary" size="mini" @click="handleDetail()">编辑</el-button>
          <el-button type="danger" size="mini" @click="handleDetail()">删除</el-button>
        </template>
      </el-table-column>
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
// checkbox 多选框
const areaOptions = ['收件箱', '走马灯']

export default {
  data() {
    return {
      // 日期(不在这里返回会不显示选择的时间)
      dpValue1: '',

      form1: {
        // 公告类型
        optionsAnnounceType: [{
          'label': '一般游戏公告',
          'value': 'gameCommon'
        }, {
          'label': '站点公告',
          'value': 'site'
        }, {
          'label': '维护公告',
          'value': 'maintain'
        }, {
          'label': '系统游戏公告',
          'value': 'gameSystem'
        }],
        gameRoom: '全部',
        vipAccount: ''
      },

      // tableData
      tableData: [{
        id: '2018-11-11 11:11:11',
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
      currentPage: 4,

      // dialog 添加公告
      dialogFormVisible: false,
      form2: {
        content: '',
        note: '',
        selectType: '系统游戏公告',
        selectStatus: '启用',
        selectTerminal: '全部',

        optionsAnnounceAddType: [{
          'label': '一般游戏公告',
          'value': 'gameCommon'
        }, {
          'label': '站点公告',
          'value': 'site'
        }, {
          'label': '维护公告',
          'value': 'maintain'
        }, {
          'label': '系统游戏公告',
          'value': 'gameSystem'
        }],

        optionsAnnounceAddStatus: [{
          label: '启用',
          value: 'enable'
        }, {
          label: '禁用',
          value: 'disable'
        }],

        optionsAnnounceAddTerminal: [{
          label: '全部',
          value: 'all'
        }, {
          label: '电脑端',
          value: 'pc'
        }, {
          label: '移动端',
          value: 'mobile'
        }]
      },

      // checkbox 多选框
      checkAll: false,
      checkedAreas: [],
      areas: areaOptions,
      isIndeterminate: true,

      formLabelWidth: '120px'
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

    },

    // checkbox 多选框
    handleCheckAllChange(val) {
      this.checkedAreas = val ? areaOptions : []
      this.isIndeterminate = false
    },
    handleCheckedAreaChange(val) {
      const checkedCount = val.length
      this.checkAll = checkedCount === this.areas.length
      this.isIndeterminate = checkedCount > 0 && checkedCount < this.areas.length
    }
  }
}
</script>
